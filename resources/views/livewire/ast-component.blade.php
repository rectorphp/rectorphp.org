<div>
    <div class="float-end mt-4">
        <a href="{{ action(\Rector\Website\Controller\Ast\AstController::class) }}"
           class="btn btn-outline-success" style="margin-top: -.7em">
            ← Create new code
        </a>
    </div>

    <div class="mt-4 mb-5" style="min-height: 30em">
        <p>Click on code part to see its AST</p>

        <div id="clickable-nodes-code" class="mb-4">
            <pre><code class="hljs">&lt;?php {!! $matrixVision !!}</code></pre>
        </div>

        <br>

        <p>Selected code is represented by following abstract syntax tree:</p>

        <div class="row">
            <div class="col-12">
                <pre><code class="language-php">{{ $simpleNodeDump }}</code></pre>
            </div>
        </div>

        <br>

        @if ($targetNodeClass)
            <p>
                What class to put into <code>Rector::getNodeTypes()</code> method to hook into?
            </p>

            <input type="text" class="form-control" onClick="this.select();" value="{{ $targetNodeClass }}::class" style="width: 25em">
        @endif

        <br>
    </div>
</div>
