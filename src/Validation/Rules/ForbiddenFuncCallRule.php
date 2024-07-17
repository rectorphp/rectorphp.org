<?php

declare(strict_types=1);

namespace App\Validation\Rules;

use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Reflection\FunctionReflection;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use PhpParser\Error;
use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\NodeFinder;
use PhpParser\ParserFactory;
use Rector\DependencyInjection\LazyContainerFactory;
use Rector\NodeTypeResolver\DependencyInjection\PHPStanServicesFactory;

final class ForbiddenFuncCallRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $parserFactory = new ParserFactory();
        $parser = $parserFactory->create(ParserFactory::PREFER_PHP7);

        $lazyContainerFactory = new LazyContainerFactory();
        $rectorContainer = $lazyContainerFactory->create();
        $signatureMapProvider = $rectorContainer->make(PHPStanServicesFactory::class)->getByType(\PHPStan\Reflection\SignatureMap\SignatureMapProvider::class);

        try {
            $stmts = $parser->parse($value);
            $nodeFinder = new NodeFinder();

            $funcCall = $nodeFinder->findFirst(
                (array) $stmts,
                function (Node $subNode) use ($signatureMapProvider): bool {
                    if (! $subNode instanceof FuncCall) {
                        return false;
                    }

                    // dynamic name? can be evil...
                    if ($subNode->name instanceof Expr) {
                        return true;
                    }

                    $namespaceName = $subNode->name->getAttribute('namespaced_name');

                    if ($namespaceName instanceof FullyQualified) {
                        $name = strtolower($namespaceName->toString());
                    } else {
                        $name = strtolower($subNode->name->toString());
                    }

                    if ($signatureMapProvider->hasFunctionMetadata($name)) {
                        $hasSideEffects = \PHPStan\TrinaryLogic::createFromBoolean($signatureMapProvider->getFunctionMetadata($name)['hasSideEffects']);
                    } else {
                        // possibly unknown
                        $hasSideEffects = \PHPStan\TrinaryLogic::createYes();
                    }

                    return $hasSideEffects->yes();
                }
            );

            if ($funcCall instanceof FuncCall) {
                $fail('PHP config should not include side effect func call');
            }
        } catch (Error $error) {
            $fail(sprintf('PHP code is invalid: %s', $error->getMessage()));
        }
    }
}
