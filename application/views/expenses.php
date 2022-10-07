
    <div id="main">
        <div class="row">
            
        	<div class="pt-3 pb-1" id="breadcrumbs-wrapper">
                <div class="container">
                    <div class="row">
                        <div class="col s12 m12 l12">
                            <h5 class="breadcrumbs-title mt-0 mb-0">
                                <span class="highlightedText">Expenses for July, 2020</span>
                            </h5>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col s12">
                <div class="container">
                    <div class="section section-data-tables">

                    	<div class="card">
                            <div class="card-content">
                                
                                <a class="btn waves-effect waves-light gradient-45deg-green-teal smallBtn right modal-trigger" href="#addExpense">
                                    ADD NEW
                                </a>
                                <a class="btn waves-effect waves-light gradient-45deg-purple-deep-orange smallBtn dropdown-trigger right" href="#!" data-target="dropdown562" style="margin-right: 5px;">
                                    JULY, 2020
                                </a>
                                <ul id="dropdown562" class="dropdown-content" tabindex="0" style="top: 30px">
                                    <li tabindex="0">
                                        <a href="" class="btnDDOption">June, 2020</a>
                                    </li>
                                    <li tabindex="0">
                                        <a href="" class="btnDDOption">May, 2020</a>
                                    </li>
                                    <li tabindex="0">
                                        <a href="" class="btnDDOption">April, 2020</a>
                                    </li>
                                    <li tabindex="0">
                                        <a href="" class="btnDDOption">March, 2020</a>
                                    </li>
                                    <li tabindex="0">
                                        <a href="" class="btnDDOption">February, 2020</a>
                                    </li>
                                    <li tabindex="0">
                                        <a href="" class="btnDDOption">January, 2020</a>
                                    </li>
                                </ul>
                                
                                <table id="page-length-option" class="display">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Date</th>
                                            <th>Amount</th>
                                            <th>Category</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php for($i = 0; $i <= 5; $i++) { ?>
                                            <tr>
                                                <td>Electricity Bill for the month of July 2020</td>
                                                <td>22/07/2020</td>
                                                <td>
                                                	₹ 43,320.23
                                                </td>
                                                <td>
                                                	<?php 
                                                		if($i == 0 || $i == 1 || $i == 2 | $i == 5) {
                                                            echo "<span class='cyan badge'>bills</span>";
                                                        }
                                                        else {
                                                            echo "<span class='orange badge'>inventory</span>";
                                                        }
                                        			?>
                                                </td>
                                                <td>
                                                	<a class="btn btn-warning-cancel waves-effect waves-light gradient-45deg-purple-deep-orange smallBtn">
                                                        DELETE
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Title</th>
                                            <th>Date</th>
                                            <th>Amount</th>
                                            <th>Category</th>
                                            <th>Actions</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <div id="addExpense" class="modal" style="width: 50%;">
        <div class="modal-content">
            <h5>Add Expense</h5>
            <form id="addClient" method="post">
                <div class="row">
                    <div class="input-field col s12" style="padding: 0px;">
                        <input type="text" id="title" name="title">
                        <label for="title" style="left: 0px;">Title</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12" style="padding: 0px;">
                        <input type="text" id="amount" name="amount">
                        <label for="amount" style="left: 0px;">Amount</label>
                    </div>
                </div>
                <div class="row">
                    <div class="file-field input-field">
                        <div class="btn mediumBtn gradient-45deg-purple-deep-orange">
                            <span>File</span>
                            <input type="file" multiple>
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text" placeholder="Upload one or more files">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="row">
                        <div class="input-field col s12" style="padding: 0px;">
                            <button class="btn waves-effect waves-light gradient-45deg-purple-deep-orange mediumBtn right" type="submit" name="action">
                                SUBMIT
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>


