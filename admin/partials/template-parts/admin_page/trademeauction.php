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
                     <legend>Listing Details</legend>
                     <div class="row">
                        <div class="col-md-12">
                           <div class="row">
                              <div class="col-md-4 editor-label">
                                 Target Account:
                              </div>
                              <div class="col-md-6">
                                 <select ng-model="Model.Account_Id" class="form-control ng-pristine ng-empty ng-invalid ng" required="">
                                    <option value="?" selected="selected"></option>
                                    <option label="Test" value="number:46">Test</option>
                                 </select>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-md-4 editor-label">
                                 Category:
                              </div>
                              <div class="col-md-6">
                                 <span class="fc_cat_value">
                                 /Trade-Me-Motors/Cars/Audi
                                 </span>
                                 <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                 Change
                                 </button>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-md-4 editor-label">
                                 Listing Title
                              </div>
                              <div class="col-md-6">
                                 <select name="ProductType" ng-model="Model.ProductType" class="form-control">
                                    <option value="specifytitle">Specify Title</option>
                                    <option value="useproductname">Use Product Name</option>
                                 </select>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-md-4 editor-label">
                                 Subtitle
                              </div>
                              <div class="col-md-6">
                                 <input type="text" class="form-control"placeholder="none">
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-md-4 editor-label">
                                 Brand New
                              </div>
                              <div class="col-md-6">
                                 <select name="ProductType" ng-model="Model.ProductType" class="form-control">
                                    <option value="brandnew">Brand New</option>
                                    <option value="used">Used</option>
                                 </select>
                              </div>
                           </div>
                           <!-- ngIf: F(112) -->
                        </div>
                     </div>
                  </fieldset>
                  <fieldset>
                     <legend>Pricing & Duration</legend>
                     <div class="row">
                        <div class="col-lg-6">
                           <div class="row">
                              <div class="col-md-4 editor-label">
                                 Listing Type
                              </div>
                              <div class="col-md-7">
                                 <select class="form-control ">
                                    <option value="1">Reserve Listing</option>
                                    <option value="2">Buy Now Only</option>
                                 </select>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-md-4 editor-label">
                                 Listing Duration
                              </div>
                              <div class="col-md-7">
                                 <div>
                                    <select ng-model="Model.Duration" class="form-control">Default</option></select>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-lg-6">
                           <div class="row">
                              <div class="col-md-4 editor-label">
                                 Pricing                                        
                              </div>
                              <div class="col-md-7">
                                 <div ng-show="F(100)" class="">
                                    <select class="form-control">
                                       <option label="Use Product Price (6.00)" value="boolean:true" selected="selected">Use Product Price (6.00)</option>
                                       <option label="Specify Pricing" >Specify Pricing</option>
                                    </select>
                                 </div>
                              </div>
                           </div>
                           <div class="row ng-hide">
                              <div class="col-md-4 editor-label">
                                 Start Price
                              </div>
                              <div class="col-md-7">
                                 <input type="text" class="form-control" >
                              </div>
                           </div>
                           <div class="row ng-hide">
                              <div class="col-md-4 editor-label">
                                 Reserve Price
                              </div>
                              <div class="col-md-7">
                                 <input type="text" class="form-control" placeholder="leave blank for start equals reserve">
                              </div>
                           </div>
                           <div class="row ng-hide">
                              <div class="col-md-4 editor-label">
                                 Buy Now Price
                              </div>
                              <div class="col-md-7">
                                 <input type="text" class="form-control">
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-md-4 editor-label">
                                 Qty Available
                              </div>
                              <div class="col-md-7">
                                 <input type="number" class="form-control">
                              </div>
                           </div>
                           <div class="row ng-hide">
                              <div class="col-md-4 editor-label">
                                 Offer Price
                              </div>
                              <div class="col-md-7">
                                 <input type="text" class="form-control">
                              </div>
                           </div>
                        </div>
                     </div>
                  </fieldset>
                  <fieldset>
                     <legend>Shipping</legend>
                     <div class="row">
                        <div class="col-md-12">
                           <div class="row">
                              <div class="col-md-4 editor-label">
                                 Shipping Price Group:
                              </div>
                              <div class="col-md-6">
                                 <select ng-model="Model.Account_Id" class="form-control">
                                    <option label="Test" value="number:46">Inherit from Product</option>
                                 </select>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-md-4 editor-label">
                                 Quantity Shipping:
                              </div>
                              <div class="col-md-6">
                                 <select ng-model="Model.Account_Id" class="form-control">
                                    <option label="Test">Charge shipping per item</option>
                                    <option label="Test">Charge shipping once</option>
                                 </select>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-md-4 editor-label">
                                 Pick-ups:
                              </div>
                              <div class="col-md-6">
                                 <select name="ProductType" class="form-control">
                                    <option value="">Default</option>
                                    <option value="">Buyer can pick-up</option>
                                    <option value="">Buyer must pick-up</option>
                                    <option value="">No pick-ups</option>
                                 </select>
                              </div>
                           </div>
                           <!-- ngIf: F(112) -->
                        </div>
                     </div>
                  </fieldset>
                  <fieldset>
                     <legend>Description</legend>
                     <div class="row">
                        <div class="col-md-12">
                           <div class="row">
                              <div class="col-md-12">
                                 <select class="form-control">
                                    <option label="Custom Description" value="number:46">Custom Description</option>
                                    <option label="Use Product Description" value="number:46">Use Product Description</option>
                                 </select>
                                 <textarea class="form-control" rows="12" readonly="" style="">demo

</textarea>
                              </div>
                           </div>
                           <!-- ngIf: F(112) -->
                        </div>
                     </div>
                  </fieldset>
               </div>
            </div>
            <div class="col-md-4 fc_addProducts_section">
               <fieldset>
                  <legend>Linked Product</legend>
                  <div class="row">
                     <div class="col-md-3 editor-label">
                        Product
                     </div>
                     <div class="col-md-7">
                        <span class="editor-value">
                        Linked to <a class="ng-binding" href="#">P00002</a>
                        <button type="button" class="btn btn-primary btn-xs" ng-click="UnlinkProduct()">unlink</button>
                        </span>
                     </div>
                  </div>
                  <div class="row" ng-show="Model.Product_Code.length > 0" style="">
                     <div class="col-md-3 editor-label">
                        Price
                     </div>
                     <div class="col-md-7">
                        <span class="editor-value ng-binding" ng-show="Product != null" style="">
                        $6.00
                        </span>
                     </div>
                  </div>
                  <div class="row" ng-show="Model.Product_Code.length > 0">
                     <div class="col-md-3 editor-label">
                        Product Stock
                     </div>
                     <div class="col-md-7">
                        <span class="editor-value ng-binding" ng-show="Product != null" style="">
                        0
                        </span>
                     </div>
                  </div>
               </fieldset>
               <fieldset>
                  <legend>Attributes</legend>
                  <div class="row ng-scope" >
                     <div class="col-md-4 editor-label">
                        Model
                     </div>
                     <div class="col-md-7 ng-scope">
                        <select class="form-control ng-pristine ng-valid ng-scope ng-empty ng-touched" ng-if="a.Options != null || a.Options.length > 0" ng-model="a.Target.Value" ng-options="o.Value as o.Display for o in a.Options" style="">
                           <option value="?" selected="selected"></option>
                           <option label="3lt Special" value="string:3lt Special">3lt Special</option>
                           <option label="Bentayga" value="string:Bentayga">Bentayga</option>
                           <option label="BenTurbo RL" value="string:BenTurbo RL">BenTurbo RL</option>
                           <option label="Continental" value="string:Continental">Continental</option>
                           <option label="Flying Spur" value="string:Flying Spur">Flying Spur</option>
                           <option label="Mulsanne" value="string:Mulsanne">Mulsanne</option>
                           <option label="R- Type" value="string:R- Type">R- Type</option>
                           <option label="Other" value="string:Other">Other</option>
                        </select>
                        <!-- end ngIf: a.Options != null || a.Options.length > 0 -->
                     </div>
                     <!-- end ngIf: a.Type == 4 -->
                  </div>
                  <!-- end ngRepeat: a in Model.CategoryDetails.Attributes -->
                  <div class="row ng-scope">
                     <div class="col-md-4 editor-label">
                        Model detail
                     </div>
                
                     <div class="col-md-7 ng-scope">
                       <input class="form-control " >
                     </div>
                     <!-- end ngIf: a.Type == 4 -->
                  </div>
                
                  <div class="row ng-scope">
                     <div class="col-md-4 editor-label">
                        Year
                     </div>
                     <!-- ngIf: a.Type < 4 -->
                     <div class="col-md-4 ng-scope">
                 
                        <div class="ng-scope">
                           <input type="number"  class="form-control "required="required">
                        </div>
                
                     </div>
             
                  </div>
         
                  <div class="row ng-scope">
                     <div class="col-md-4 editor-label">
                        Kilometres
                     </div>
                     <!-- ngIf: a.Type < 4 -->
                     <div class="col-md-4 ng-scope" ng-if="a.Type < 4">
                  
                        <div ng-if="a.Type == 2" class="ng-scope">
                           <input type="number" class="form-control ng-pristine" min="0" max="2000000">
                        </div>
                       
                     </div>
              
                  </div>
                
                  <div class="row ng-scope">
                     <div class="col-md-4 editor-label">
                        Approximate value
                     </div>
                     <!-- ngIf: a.Type < 4 -->
                     <div class="col-md-4 ng-scope" >
                   
                        <div class="ng-scope">
                           <input type="number" ng-model="a.Target.Value" class="form-control">
                        </div>
                       
                     </div>
             
                  </div>
       
                  <div class="row ng-scope">
                     <div class="col-md-4 editor-label">
                        Exterior colour
                     </div>
                 
                     <div class="col-md-7 ng-scope" ng-if="a.Type == 4">
                   <input type="text" class="form-control ng-pristineh">
                     </div>
    
                  </div>
                
                  <div class="row ng-scope">
                     <div class="col-md-4 editor-label">
                        On road costs included
                     </div>
                 
                     <div class="col-md-4 ng-scope" >
                     
                        <div class="ng-scope">
                           <input type="checkbox">
                        </div>
                       
                     </div>
                
                  </div>
  
                  <div class="row ng-scope">
                     <div class="col-md-4 editor-labelg">
                        Doors
                     </div>
               
                     <div class="col-md-4 ng-scope">
               
                        <div class="ng-scope">
                           <input type="number"  class="form-control" min="" max="" >
                        </div>
                        
                     </div>
            
                  </div>
             
                  <div class="row ng-scope" >
                     <div class="col-md-4 editor-label">
                        Body style
                     </div>
            
                     <div class="col-md-7 ng-scope" ng-if="a.Type == 4">
              
                        <select class="form-control ">
                           <option value="?" selected="selected"></option>
                           <option label="Convertible" value="string:Convertible">Convertible</option>
                           <option label="Coupe" value="string:Coupe">Coupe</option>
                           <option label="Hatchback" value="string:Hatchback">Hatchback</option>
                           <option label="Sedan" value="string:Sedan">Sedan</option>
                           <option label="Station Wagon" value="string:StationWagon">Station Wagon</option>
                           <option label="RV/SUV" value="string:RVSUV">RV/SUV</option>
                           <option label="Ute" value="string:Ute">Ute</option>
                           <option label="Van" value="string:Van">Van</option>
                           <option label="Other" value="string:Other">Other</option>
                        </select>
                       
                     </div>
              
                  </div>
                
                  <div class="row ng-scope">
                     <div class="col-md-4 editor-label ng-binding">
                        Seats
                     </div>
               
                     <div class="col-md-4 ng-scope">
        
                        <div class="ng-scope">
                           <input type="number"class="form-control" min="0" max="99" >
                        </div>
                  
                     </div>
              
                  </div>
           
                  <div class="row ng-scope" >
                     <div class="col-md-4 editor-label">
                        Fuel type
                     </div>
                
                     <div class="col-md-7 ng-scope">
    
                        <select class="form-control">
                           <option value="?" selected="selected"></option>
                           <option label="Petrol" value="string:Petrol">Petrol</option>
                           <option label="Diesel" value="string:Diesel">Diesel</option>
                           <option label="Hybrid" value="string:Hybrid">Hybrid</option>
                           <option label="Plug-in hybrid" value="string:Pluginhybrid">Plug-in hybrid</option>
                           <option label="Electric" value="string:Electric">Electric</option>
                           <option label="LPG" value="string:LPG">LPG</option>
                           <option label="Alternative" value="string:Alternative">Alternative</option>
                        </select>
                       
                     </div>
                   
                  </div>
              
                  <div class="row ng-scope">
                     <div class="col-md-4 editor-label">
                        Cylinders
                     </div>
                     <!-- ngIf: a.Type < 4 -->
                     <div class="col-md-4 ng-scope">
     
                        <div  class="ng-scope">
                           <input type="number"class="form-control" min="" max="">
                        </div>
                
                     </div>
          
                  </div>
                
                  <div class="row ng-scope">
                     <div class="col-md-4 editor-label">
                        Engine size
                     </div>
                  
                     <div class="col-md-4 ng-scope">
            
                        <div class="ng-scope">
                           <input type="number"class="form-control" min="1" max="100000" >
                        </div>
               
                     </div>
           
                  </div>
          
                  <div class="row ng-scope">
                     <div class="col-md-4 editor-label">
                        Transmission
                     </div>
                     <!-- ngIf: a.Type < 4 -->
                     <div class="col-md-4 ng-scope">
             
                        <div class="ng-scope">
                           <input type="number" class="form-control" min="" max="">
                        </div>
                  
                     </div>
                
                  </div>
                 
                  <div class="row ng-scope">
                     <div class="col-md-4 editor-label">
                        4WD
                     </div>
               
                     <div class="col-md-4 ng-scope">
                       
                        <div class="ng-scope">
                           <input type="checkbox"class="ng-pristine">
                        </div>
                   
                     </div>
       
                  </div>
                  
                  <div class="row ng-scope">
                     <div class="col-md-4 editor-label">
                        Number of owners
                     </div>
                  
                     <div class="col-md-4 ng-scope">
               
                        <div class="ng-scope">
                           <input type="number"class="form-control " min="" max="">
                        </div>
                  
                     </div>
            
                  </div>
                
                  <div class="row ng-scope">
                     <div class="col-md-4 editor-label ">
                        Import history
                     </div>
                   
                     <div class="col-md-4 ng-scope">
                
                        <div class="ng-scope">
                           <input type="number"class="form-control" min="" max="" >
                        </div>
               
                     </div>
   
                  </div>
     
                  <div class="row ng-scope">
                     <div class="col-md-4 editor-label ">
                        Registration expires
                     </div>
           
                     <div class="col-md-7 ng-scope">
               
                        <select class="form-control">
                           <option value="?" selected="selected"></option>
                           <option label="No Registration" value="string:No Registration">No Registration</option>
                           <option label="July 21" value="string:July 21">July 21</option>
                           <option label="August 21" value="string:August 21">August 21</option>
                           <option label="September 21" value="string:September 21">September 21</option>
                           <option label="October 21" value="string:October 21">October 21</option>
                           <option label="November 21" value="string:November 21">November 21</option>
                           <option label="December 21" value="string:December 21">December 21</option>
                           <option label="January 22" value="string:January 22">January 22</option>
                           <option label="February 22" value="string:February 22">February 22</option>
                           <option label="March 22" value="string:March 22">March 22</option>
                           <option label="April 22" value="string:April 22">April 22</option>
                           <option label="May 22" value="string:May 22">May 22</option>
                           <option label="June 22" value="string:June 22">June 22</option>
                           <option label="July 22" value="string:July 22">July 22</option>
                        </select>
                
                     </div>
                 
                  </div>
                
                  <div class="row ng-scope">
                     <div class="col-md-4 editor-label">
                        WoF expires
                     </div>
                     <div class="col-md-7 ng-scope">
                        <select class="form-control">
                           <option value="?" selected="selected"></option>
                           <option label="No WOF" value="string:No WOF">No WOF</option>
                           <option label="July 21" value="string:July 21">July 21</option>
                           <option label="August 21" value="string:August 21">August 21</option>
                           <option label="September 21" value="string:September 21">September 21</option>
                           <option label="October 21" value="string:October 21">October 21</option>
                           <option label="November 21" value="string:November 21">November 21</option>
                           <option label="December 21" value="string:December 21">December 21</option>
                           <option label="January 22" value="string:January 22">January 22</option>
                           <option label="February 22" value="string:February 22">February 22</option>
                           <option label="March 22" value="string:March 22">March 22</option>
                           <option label="April 22" value="string:April 22">April 22</option>
                           <option label="May 22" value="string:May 22">May 22</option>
                           <option label="June 22" value="string:June 22">June 22</option>
                           <option label="July 22" value="string:July 22">July 22</option>
                           <option label="August 22" value="string:August 22">August 22</option>
                           <option label="September 22" value="string:September 22">September 22</option>
                           <option label="October 22" value="string:October 22">October 22</option>
                           <option label="November 22" value="string:November 22">November 22</option>
                           <option label="December 22" value="string:December 22">December 22</option>
                           <option label="January 23" value="string:January 23">January 23</option>
                           <option label="February 23" value="string:February 23">February 23</option>
                           <option label="March 23" value="string:March 23">March 23</option>
                           <option label="April 23" value="string:April 23">April 23</option>
                           <option label="May 23" value="string:May 23">May 23</option>
                           <option label="June 23" value="string:June 23">June 23</option>
                           <option label="July 23" value="string:July 23">July 23</option>
                           <option label="August 23" value="string:August 23">August 23</option>
                           <option label="September 23" value="string:September 23">September 23</option>
                           <option label="October 23" value="string:October 23">October 23</option>
                           <option label="November 23" value="string:November 23">November 23</option>
                           <option label="December 23" value="string:December 23">December 23</option>
                           <option label="January 24" value="string:January 24">January 24</option>
                           <option label="February 24" value="string:February 24">February 24</option>
                           <option label="March 24" value="string:March 24">March 24</option>
                           <option label="April 24" value="string:April 24">April 24</option>
                           <option label="May 24" value="string:May 24">May 24</option>
                           <option label="June 24" value="string:June 24">June 24</option>
                           <option label="July 24" value="string:July 24">July 24</option>
                        </select>
                     </div>
                  </div>
                  <div class="row ng-scope">
                     <div class="col-md-4 editor-label">
                        Number plate
                     </div>
           
                     <div class="col-md-7 ng-scope" ng-if="a.Type == 4">
                    <input type="text" class="form-control ng-pristine ">
                     </div>
                  
                  </div>
               
                  <div class="row ng-scope">
                     <div class="col-md-4 editor-label">
                        Show number plate
                     </div>
         
                     <div class="col-md-4 ng-scope" >
                  
                        <div class="ng-scope">
                           <input type="checkbox">
                        </div>
               
                     </div>
          
                  </div>
                 
                  <div class="row ng-scope">
                     <div class="col-md-4 editor-label ">
                        AA Inspection Report
                     </div>
                  
                     <div class="col-md-4 ng-scope">
                 
                        <div  class="ng-scope">
                           <input type="checkbox">
                        </div>
             
                     </div>
       
                  </div>
       
                  <div class="row ng-scope">
                     <div class="col-md-4 editor-label">
                        Stereo description
                     </div>
               
                     <div class="col-md-7 ng-scope">
                      <input type="text" class="form-control " >

                     </div>
            
                  </div>
           
                  <div class="row ng-scope">
                     <div class="col-md-4 editor-label ">
                        Best contact time
                     </div>
            
                     <div class="col-md-7 ng-scope" >
          
                        <select class="form-control">
                           <option value="?" selected="selected"></option>
                           <option label="Any time" value="string:Anytime">Any time</option>
                           <option label="Morning" value="string:Morning">Morning</option>
                           <option label="Afternoon" value="string:Afternoon">Afternoon</option>
                           <option label="Evening" value="string:Evening">Evening</option>
                           <option label="Business hours" value="string:Businesshours">Business hours</option>
                        </select>
                      
                     </div>
                   
                  </div>
                
                  <div class="row ng-scope">
                     <div class="col-md-4 editor-label">
                        ABS brakes
                     </div>
                    
                     <div class="col-md-4 ng-scope" >
                       
                        <div class="ng-scope">
                           <input type="checkbox" ng-model="a.Target.Value" class="ng-pristine ng-untouched ng-valid ng-empty">
                        </div>
             
                     </div>
                  
                  </div>
                 
                  <div class="row ng-scope">
                     <div class="col-md-4 editor-label">
                        Air conditioning
                     </div>
                
                     <div class="col-md-4 ng-scope">
                       
                        <div class="ng-scope">
                           <input type="checkbox">
                        </div>
                
                     </div>
           
                  </div>
         
                  <div class="row ng-scope">
                     <div class="col-md-4 editor-label">
                        Alarm
                     </div>
          
                     <div class="col-md-4 ng-scope">
                      
                        <div class="ng-scope">
                           <input type="checkbox" class="ng-pristine">
                        </div>
                    
                     </div>
            
                  </div>
                
                  <div class="row ng-scope">
                     <div class="col-md-4 editor-label">
                        Alloy wheels
                     </div>
               
                     <div class="col-md-4 ng-scope">
                    
                        <div class="ng-scope">
                           <input type="checkbox" class="ng-pristine">
                        </div>
                
                     </div>
            
                  </div>
                 
                  <div class="row ng-scope">
                     <div class="col-md-4 editor-label ng-binding">
                        Central locking
                     </div>
                  
                     <div class="col-md-4 ng-scope">
               
                        <div  class="ng-scope">
                           <input type="checkbox">
                        </div>
                   
                     </div>
           
                  </div>
            
                  <div class="row ng-scope">
                     <div class="col-md-4 editor-label">
                        Driver airbag
                     </div>
                
                     <div class="col-md-4 ng-scope">
        
                        <div class="ng-scope">
                           <input type="checkbox">
                        </div>
                   
                     </div>
            
                  </div>
                  
                  <div class="row ng-scope">
                     <div class="col-md-4 editor-label">
                        Passenger airbag
                     </div>
               
                     <div class="col-md-4 ng-scope" >
               
                        <div class="ng-scope">
                           <input type="checkbox"class="ng-pristine">
                        </div>
                     
                     </div>
            
                  </div>
     
                  <div class="row ng-scope">
                     <div class="col-md-4 editor-label">
                        Power steering
                     </div>
                    
                     <div class="col-md-4 ng-scope">
                       
                        <div class="ng-scope">
                           <input type="checkbox"class="ng-pristine">
                        </div>
                       
                     </div>
          
                  </div>
                  
                  <div class="row ng-scope">
                     <div class="col-md-4 editor-label ">
                        Sunroof
                     </div>
                    
                     <div class="col-md-4 ng-scope">
                 
                        <div ng-if="a.Type == 1" class="ng-scope">
                           <input type="checkbox"class="ng-pristine">
                        </div>
           
                     </div>
          
                  </div>
                  <div class="row ng-scope">
                     <div class="col-md-4 editor-label ng-binding">
                        Towbar
                     </div>
           
                     <div class="col-md-4 ng-scope">
                   
                        <div class="ng-scope">
                           <input type="checkbox" class="ng-pristine">
                        </div>
                    
                     </div>
    
                  </div>
                
               </fieldset>
               <fieldset>
                        <legend>Photos &amp; Promotion</legend>
                        <div class="row">
                            <div class="col-md-4 editor-label">
                                Photo Source
                            </div>
                            <div class="col-md-7">
                                <div class="">
                                    <select class="form-control ">
                                        <option label="Custom Photos" value="boolean:false">Custom Photos</option>
                                        <option label="Use Product Photos" value="boolean:true" selected="selected">Use Product Photos</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row" >
                            <div class="col-md-4 editor-label">
                                Product Photos
                            </div>
                            <div class="col-md-7">
                                <div  class="">
                                    <select class="form-control">
                                        <option label="Use all photos" selected="selected">Use all photos</option>
                                        <option label="Main photo only" >Main photo only</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 editor-label">
                                Promotion
                            </div>
                            <div class="col-md-7">
                                <div>
                                    <select class="form-control ng-valid"></select>
                                </div>
                            </div>
                        </div>

                     <ul style="list-style: none; margin: 1em; padding: 0px; min-height: 164px; border: 1px dashed rgb(170, 170, 170);" ng-if="Model.UseProductImages == true" class="ng-scope">
                        </ul>
                        <div class="row ng-hide" ng-show="Model.UseProductImages == false" style="">
                            <div class="col-md-3 editor-label">
                            </div>
                            <div class="col-md-7">
                                <label for="AuctionAddImageButton" class="btn btn-sm btn-primary"> Add Image(s)</label>
                                <input type="file" id="AuctionAddImageButton" ng-file-select="ImageSelected($files)" multiple="" accept="image/*" style="visibility: hidden;">
                            </div>
                        </div>
                    </fieldset>

                    <fieldset>
                        <legend>Scheduled Functions</legend>
                        <div class="row">
                            <div class="col-md-4 editor-label">
                                Automatic Loading
                            </div>
                            <div class="col-md-7">
                                <select  class="form-control">
                                    <option label="Disabled" value="boolean:false">Disabled</option>
                                    <option label="Enabled" value="boolean:true" selected="selected">Enabled</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 editor-label">
                                Loading Schedule
                            </div>
                            <div class="col-md-7">
                                <div>
                                    <select class="form-control">
                                        <option selected="selected"></option>
                                        <option label="DE" value="de">DE</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 editor-label">
                                Concurrent Listings
                            </div>
                            <div class="col-md-7">
                                <div>
                                    <input type="number" class="form-control ">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 editor-label">
                                Automatic Offers
                            </div>
                            <div class="col-md-7">
                                <select class="form-control">
                                    <option label="Disabled" value="">Disabled</option>
                                    <option label="Enabled" value="" selected="selected">Enabled</option>
                                </select>
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
                           <option label="To Rent" value="">To Rent</option>
                        </select>
                     </div>
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