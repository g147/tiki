<div class="forms">
    <h2>{tr}Forms{/tr}</h2>
    <div class="row">
        <div class="col-sm-8 col-md-9">
            <form class="tc-form" method="post" action="#">
                <fieldset>
                    <p class="form-group">
                        <label for="tc-username-example">{tr}Username{/tr}</label>
                        <input id="tc-username-example" class="nocolor form-control" type="text" value="Username">
                    </p>
                    <p class="has-error form-group">
                        <label for="tc-password-example">{tr}Password{/tr}</label>
                        <input id="tc-password-example" class="nocolor form-control" type="password">
                        <label class="label label-warning">{tr}This field is required{/tr}</label>
                    </p>
                    <p class="form-group">
                        <input id="tc-remember-example" type="checkbox"> {tr}Remember me{/tr}
                    </p>
                    <p class="form-group">
                        <button class="btn btn-primary">{tr}Login{/tr}</button>
                    </p>
                    <hr/>

                    <p class="has-error form-group">
                        <label for="tc-text-example">{tr}Text field{/tr}</label>
                        <input id="tc-text-example" class="nocolor form-control" type="text">
                        <label class="label label-warning">{tr}This field is required{/tr}</label>
                    </p>
                    <p class="form-group">
                        <label for="tc-textarea-example">{tr}Textarea{/tr}</label>
                        <textarea id="tc-textarea-example" class="nocolor form-control" rows="3">{tr}This is a textarea field{/tr}</textarea>
                    </p>
                    <p class="form-group">
                        <label for="tc-select-example">{tr}Select{/tr}</label> <select id="tc-select-example" class="nocolor form-control">
                            <option>{tr}Option 1{/tr}</option>
                            <option>{tr}Option 2{/tr}</option>
                            <option>{tr}Option 3{/tr}</option>
                            <option>{tr}Option 4{/tr}</option>
                        </select>
                    </p>
                    <p class="form-group">
                        <label for="tc-checkbox-example">{tr}Checkbox{/tr}</label>
                        <input id="tc-checkbox-example" type="checkbox">
                        {tr}This is a checkbox{/tr}
                    </p>
                    <p class="form-group">
                        <label for="tc-radio-example">{tr}Radio{/tr}</label>
                        <input id="tc-radio-example" name="radio" type="radio">
                        {tr}This is a radio button{/tr}
                    </p>
                    <p><input name="radio" type="radio"> {tr}This is another radio button{/tr}</p>
                </fieldset>
            </form>
        </div>

        <div class="col-sm-4 col-md-3">
            <div class="input">
                <p class="picker" data-selector=".form-control" data-element="background-color">
                    <label for="tc-field-bg-color">{tr}Background{/tr}:</label>
                    <input id="tc-field-bg-color" data-selector=".form-control" data-element="background-color" data-var="@input-bg" type="text">
                    <span class="input-group-addon"><i></i></span>
                </p>
                <p class="picker" data-selector=".form-control" data-element="border-color">
                    <label for="tc-field-border-color">{tr}Border{/tr}:</label>
                    <input id="tc-field-border-color" data-selector=".form-control" data-element="border-color" data-var="@input-border" type="text">
                    <span class="input-group-addon"><i></i></span>
                </p>
                <p class="picker" data-selector=".form-control" data-element="color">
                    <label for="tc-field-text-color">{tr}Text{/tr}:</label>
                    <input id="tc-field-text-color" data-selector=".form-control" data-element="color" data-var="@input-color" type="text">
                    <span class="input-group-addon"><i></i></span>
                </p>
                <p>
                    <label for="tc-field-padding">{tr}Padding{/tr}:</label>
                    <input id="tc-field-padding" class="nocolor" data-selector=".form-control" data-element="padding" type="text">
                </p>
            </div>
        </div>
    </div>
</div>
