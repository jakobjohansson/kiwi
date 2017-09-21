@include(framework.Admin.Views.partials.admin-header)

<div class="column is-offset-3 is-6">
    <form method="post" action="write">
        <div class="field">
            <label class="label">Title</label>
            <div class="control">
                <input type="text" class="input" name="title" placeholder="Title"/>
            </div>
            @if ($errors->title)
                @foreach ($errors->title as $error)
                    <p class='help is-danger'>{{$error}}</p>
                @endforeach
            @endif
        </div>
        <div class="field">
            <label class="label">Body</label>
            <div class="control">
                <textarea class="textarea" rows="10" name="body"></textarea>
            </div>
            @if ($errors->body)
                @foreach ($errors->body as $error)
                    <p class='help is-danger'>{{$error}}</p>
                @endforeach
            @endif
        </div>
        <div class="field is-grouped is-grouped-right">
            <div class="control">
                <input type="submit" class="button" name="draft" value="Draft" />
            </div>
            <div class="control">
                <input type="submit" class="button is-danger" name="publish" value="Publish" />
            </div>
        </div>
    </form>
</div>

@include(framework.Admin.Views.partials.admin-footer)
