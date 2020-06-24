<div class="row justify-content-center w-100">
    <div class="col-md-8">
        <form method="get" class="search-form" action="{{ route('recipe.index') }}">
            <div class="search-box">

                <div class="row">
                    <div class="col-md-3 col-sm-3 col-xs-6">
                        <div class="form-group">
                            <select name="c" id="recipe-type" class="form-control">
                                <option value="0" selected="selected"> – Choose Category –</option>
                                <option class="level-0" value="14">Bakery</option>
                                <option class="level-0" value="18">Budget</option>
                                <option class="level-0" value="20">Cheese</option>
                                <option class="level-0" value="21">Chicken</option>
                                <option class="level-0" value="25">Condiment</option>
                                <option class="level-0" value="27">Cookie</option>
                                <option class="level-0" value="42">Gluten-Free</option>
                                <option class="level-0" value="59">Pizzas</option>
                                <option class="level-0" value="60">Potatos</option>
                                <option class="level-0" value="62">Rolls</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-3 col-xs-6">
                        <div class="form-group">
                            <input class="form-control" placeholder="Search by Keyword" value="" name="s">
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-6">
                        <div class="action-buttons w-100 text-center">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i>
                                Search
                            </button>
                            <button type="reset" class="btn"><i class="fa fa-times"></i> Clear</button>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>
