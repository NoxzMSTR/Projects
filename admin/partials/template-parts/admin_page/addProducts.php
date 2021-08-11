<!DOCTYPE html>
<html>
<head>
<title>Title of the document</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="style.css">


</head>

<body>
   <div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
   
<div class="fc_addProducts_section">
	<fieldset> 

                        <legend>Product</legend>

                        <div class="row">
                          
                            <div class="col-md-4">

                                <div class="row">
                                    <div class="col-md-4 editor-label">
                                        Name
                                    </div>
                                      <div class="col-md-8">
                                        <input type="text" maxlength="32" class="form-control" >
                                       
                                    </div>
                                
                                </div>

                                <div class="row">
                                    <div class="col-md-4 editor-label">
                                        Code/SKU
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" maxlength="32" class="form-control" >
                                     
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 editor-label">
                                        Type
                                    </div>
                                    <div class="col-md-8">
                                        <select name="ProductType" ng-model="Model.ProductType" class="form-control">
                                            <option value="stocked">Standard</option>
                                            <option value="unlimitedstock">Unlimited Stock</option>
                                            <option value="batched">Batch Product</option>
                                            <option value="combo">Combo</option>
                                            <option value="variations">Variations</option>
                                            <option value="shipping">Shipping</option>
                                        </select>
                            
                                    </div>
                                </div>
                                <div ng-show="Model.ProductType == 'batched'" class="row ng-hide">
                                    <div class="col-md-4 editor-label">

                                    </div>
                                    <div class="col-md-8 editor-value">
                                        <input type="checkbox" id="trackexpirydates" >
                                        <label for="trackexpirydates">Track Expiry Dates</label>
                                    </div>
                                </div>
                                <!-- ngIf: F(112) -->
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-4 editor-label">
                                        Status
                                    </div>
                                    <div class="col-md-8">
                                        <select ng-model="Model.State_Id" class="form-control">
                                        	<option label="Active" value="">Active</option>
                                        	<option label="Hold" value="">Hold</option>
                                        </select>
                                   
                                    </div>
                                </div>

                                <!-- ngIf: F(102) -->



                                <div class="row">
                                    <div class="col-md-4 editor-label">Barcode</div>
                                    <div class="col-md-8">
                                        <input type="text" name="ProductBarcode" id="ProductBarcode" ng-model="Model.Barcode" maxlength="30" class="form-control ng-pristine ng-untouched ng-valid ng-empty ng-valid-maxlength" audit="">
                                    
                                    </div>
                                </div>
                                <!-- ngIf: F(106) -->
                            </div>
                            <div class="col-md-4">

                                <!-- ngIf: Model.ProductType !='variations' --><div class="row ng-scope" ng-if="Model.ProductType !='variations'">
                                    <div class="col-md-4 editor-label">
                                        Sell Price
                                    </div>
                                    <div class="col-md-7">
                                        <div class="input-group">
                                            <input type="text" name="ProductPrice" id="ProductPrice" ng-model="Model.Price" ng-currency="" min="0" max="9999999999" hard-cap="true" class="form-control"  required="required">
                                            <span class="input-group-addon">
                                                <select class="form-control">
                                                	<option label="Ex Tax" value="Ex Tax">Ex Tax</option>
                                                	<option label="Inc Tax" value="Inc Tax" selected="selected">Inc Tax</option>
                                                </select>
                                            </span>
                                        </div>
                                        <span class="glyphicon glyphicon-question-sign" uib-tooltip="The price this product is to be sold at. See help for more information on per-customer pricing and discounts"></span>
                                    </div>
                                </div><!-- end ngIf: Model.ProductType !='variations' -->

                                <!-- ngIf: Model.ProductType !='variations' --><div class="row ng-scope">
                                    <div class="col-md-4 editor-label">
                                        Last Cost
                                    </div>
                                    <div class="col-md-7">
                                        <input type="text" ng-currency="" min="0" max="9999999999" class="form-control >
                                     
                                        <span style="font-style: italic;"  class="ng-hide">(calculated)</span>
                                    </div>
                                </div><!-- end ngIf: Model.ProductType !='variations' -->

                                <!-- ngIf: F(105) --><div class="row ng-scope" ng-if="F(105)">
                                    <div class="col-md-4 editor-label">
                                        RRP
                                    </div>
                                    <div class="col-md-7">
                                        <input type="text" name="ProductRRP" id="ProductRRP" ng-currency="" min="0" max="9999999999" class="form-control">
                                      
                                    </div>
                                </div><!-- end ngIf: F(105) -->
                                <!-- ngIf: PriceExTax != undefinied && PriceExTax != null -->
                            </div>
                        </div>
                 
                    </fieldset>






                    <fieldset> 

                        <legend>Categories</legend>
<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Select Categories</button>
                    </fieldset>
</div>
       </div>




 <div class="col-md-4 fc_addProducts_section">
                    <fieldset> 

                        <legend>Stock</legend>
<div class="row ng-scope">
                            <div class="col-md-4 editor-label">Total Stock:</div>
                            <div class="col-md-2">
                                <span class="fc_totalStock">0</span>
                            </div>
                            <div class="col-md-6" ng-show="ExistsOnServer">
                                <!-- ngIf: StockModel.Stock.TotalStock > 0 -->
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#totalStock" >
                                    Add New Stock
                                </button>
                            </div>
                        </div>

                        <div class="row ng-scope" >
                            <div class="col-md-4 editor-label">
                                Reorder Level:
                            </div>
                            <div class="col-md-3">
                                <input type="number" class="form-control"">
                               
                            </div>
                        </div>
                        <div class="row ng-scope" ng-if="ExistsOnServer">
                            <div class="col-md-4 editor-label">
                                Cluster Stock:
                            </div>
                            <div class="col-md-3">
                                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#stockQuery">
                                    View
                                </button>
                            </div>
                        </div>
                    </fieldset>
                </div>
  

</div>

</div>


<!-- The Modal -->
  <div class="modal fade " id="myModal" role="dialog" >
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Select Categories</h4>
          <div class="fc_actionbutton">
                 <button type="button" class="btn btn-success" data-dismiss="modal">Save</button>
          <small>OR</small>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
          </div>
 

        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
          <div class="row">
              <div class="col-md-3">
                  <select style="width: 100%;" size="30" >
                    <option value="?" selected="selected"></option>
                    <option label="Trade Me Motors" value="">Trade Me Motors</option>
                    <option label="Trade Me Property" value="">Trade Me Property</option>
                    <option label="Trade Me Jobs" value="">Trade Me Jobs</option>
                    <option label="Antiques &amp; collectables" value="">Antiques &amp; collectables</option>
                    <option label="Art" value="object:1900">Art</option>
                    <option label="Baby gear" value="">Baby gear</option>
                    <option label="Books" value="">Books</option>
                    <option label="Building &amp; renovation" value="">Building &amp; renovation</option>
                    <option label="Business, farming &amp; industry" value="">Business, farming &amp; industry</option>
                    <option label="Clothing &amp; Fashion" value="">Clothing &amp; Fashion</option>
                    <option label="Computers" value="">Computers</option>
                    <option label="Crafts" value="">Crafts</option>
                    <option label="Electronics &amp; photography" value="">Electronics &amp; photography</option>
                    <option label="Flatmates wanted" value="">Flatmates wanted</option>
                    <option label="Gaming" value="">Gaming</option>
                    <option label="Health &amp; beauty" value="">Health &amp; beauty</option>
                    <option label="Home &amp; living" value="">Home &amp; living</option>
                    <option label="Jewellery &amp; watches" value="">Jewellery &amp; watches</option>
                    <option label="Mobile phones" value="">Mobile phones</option>
                    <option label="Movies &amp; TV" value="">Movies &amp; TV</option>
                    <option label="Music &amp; instruments" value="">Music &amp; instruments</option>
                    <option label="Pets &amp; animals" value="">Pets &amp; animals</option>
                    <option label="Pottery &amp; glass" value="">Pottery &amp; glass</option>
                    <option label="Services" value="">Services</option>
                    <option label="Sports" value="">Sports</option>
                    <option label="Toys &amp; models" value="">Toys &amp; models</option>
                    <option label="Travel, events &amp; activities" value="">Travel, events &amp; activities</option>
                </select>


              </div>
              <div class="col-md-3">
                <select style="width: 100%;" size="30">
                    <option value="?" selected="selected"></option>
                    <option label="Commercial Property" value="">Commercial Property</option>
                    <option label="New homes" value="">New homes</option>
                    <option label="Residential" value="">Residential</option>
                    <option label="Retirement villages" value="">Retirement villages</option>
                    <option label="Rural" value="">Rural</option>
                </select>
            </div>
              <div class="col-md-3">
                <select style="width: 100%;" size="30" >
                    <option value="?" selected="selected"></option>
                    <option label="Car parks" value="">Car parks</option>
                    <option label="For Sale" value="">For Sale</option>
                    <option label="Sections for sale" value="">Sections for sale</option>
                    <option label="Lifestyle property" value="">Lifestyle property</option>
                    <option label="To Rent" value="">To Rent</option></select></div>
              <div class="col-md-3">3</div>
          </div>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-success" data-dismiss="modal">Save</button>
          <small>OR</small>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        </div>
        
      </div>

    </div>
 
  </div>




<!-- Total Stock -->
<div class="modal fade" id="totalStock" aria-modal="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" >Add Stock</h5>
        <div class="fc_actionbutton">
                 <button type="button" class="btn btn-success" data-dismiss="modal">Save</button>
          <small>OR</small>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
          </div>
      </div>
      <div class="modal-body fc_stockMange">

        <div class="row">
            <div class="col-md-4 editor-label">Stock To Add:</div>
            <div class="col-md-7">
                <input type="number" step="any" class="form-control" required="" >
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 editor-label">Cost Price Each:</div>
            <div class="col-md-7">
                <input type="text" ng-currency=""class="form-control">
            </div>
        </div>
      </div>
      <div class="modal-footer">

        <button type="button" data-dismiss="modal" class="btn btn-success">Save</button>
                <small>OR</small>
        <button type="button" class="btn btn btn-danger" data-dismiss="modal">Cancel</button>

      </div>
    </div>
  </div>
</div>


<!-- Stock Query
 -->
<div class="modal fade" id="stockQuery" aria-modal="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" >Stock Query</h5>
        <div class="fc_actionbutton">
           
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
          </div>
      </div>
      <div class="modal-body fc_stockQuery">

      <table class="table striped-table">
            <thead>
                <tr>
                    <th>Database</th>
                    <th>Stock Level</th>
                </tr>
            </thead>
            <tbody>
                <!-- ngRepeat: ci in ClusterInstances -->
            </tbody>
        </table>

      
      </div>
      <div class="modal-footer">

     
        <button type="button" class="btn btn btn-danger" data-dismiss="modal">Cancel</button>

      </div>
    </div>
  </div>
</div>

   </div>
</body>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>



</html>