(function ( $ ) {
$._l = function(area,subarea,action,params){
    
    action = action || "";
    params = params || {};
    
    var s_params = "";    
    if (params)
    {        
        for (name in params){            
            s_params  += "&" + name + "=" + params[name];
        };
    }
    
    return "<?php echo INDEX; ?>" + "?area=" + area + "&subarea=" + subarea + "&action=" + action + s_params;
};
$._r = function (area,data,options) {
    var ajax_args= options;
    ajax_args.url = "<?php echo INDEX; ?>";
    ajax_args.dataType= "json";
    ajax_args.data={};
    for (var d in data)
        ajax_args.data[d] = data[d];
    for (var a in area)
    {
        ajax_args.data[a] = area[a];
    }
    $.ajax(ajax_args);
    return this;
};

function escapeHTML( string )
            {
                var pre = document.createElement('pre');
                var text = document.createTextNode( string );
                pre.appendChild(text);
                return pre.innerHTML;
            }
			
            /**
             * Create a model for a view of the data object
             * */
            function DataView(render_callback){
               this._element = undefined;
               this._callback = render_callback;
               this.update = function(data){
                  var parameter = data;
                  if (this._element) 
                     $(this._element).html( $(this._callback(data)).html());
                  else
                     this._element = this._callback(data);
               };
               this.el = function() { return this._element;};
            };
            
	        /**
             * Make a structured 
	        * */            
            function DataObject() {
               //this.data= new Object();
               this.views=new Object();
            };
            
            DataObject.prototype.data = {}
            /**
            * Add a method to store a view
            * */
            DataObject.prototype.addView = function(name,view_object)
            {
               this.views[name]= view_object;
            }
            
            DataObject.prototype.getView = function(name)
            {
               return this.views[name];
            }
            
            DataObject.prototype.get = function(name)
            {
               
               //return this.data[name];
               return this[name];
            };
            
            DataObject.prototype.getEscaped = function(name)
            {
               return escapeHTML(this[name]);
            };
            
            DataObject.prototype.set = function(values)
            {
               //Update all the object property
               for (var name in values)
               {
                  this.data[name]=values[name];
                  this[name]=values[name];
               }
               
               //Update all the object views 
               for (var k in this.views)
               {
                  if (!!k && this.views.hasOwnProperty(k))
                  {
                     this.views[k].update(this);
                  }
               }
            };

<?php

    if (isset($_SESSION["user"])) {
        $roles = json_encode($_SESSION["user"]->roles);
echo <<<EOL
    var o_User = {
        id : "{$_SESSION["user"]->username}",
        display_name : "{$_SESSION["user"]->display_name}",
        roles :  $roles
    };    
EOL;
    }
?>
}( jQuery ));