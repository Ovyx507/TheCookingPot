var app = app || {};

(function(o){
    "use strict";
    
    //Private methods
    var ajax, getFormData;
    
    ajax = function(data){
        var xmlhttp = new XMLHttpRequest(), uploaded;

		xmlhttp.addEventListener('readystatechange', function(){
			if(this.readyState === 4)
			{
				if(this.status === 200){
					uploaded = JSON.parse(this.response);
					
					if(typeof o.options.finished === 'function'){
						o.options.finished(uploaded);
					}
				}
				else
				{
					if(typeof o.options.error === 'function'){
						o.options.error();
					}
				}
			}
		});

		xmlhttp.open('post', o.options.processor);
        xmlhttp.send(data);
        
    };
    
    getFormData = function(source){
		var data = new FormData(), i;

		for(i = 0; i < source.length; i++)
		{
			data.append('file[]',source[i]);
		}

		data.append('ajax', true);

		return data;
    };

    o.uploader  =  function(options){
        o.options = options;
		var accepted = ['image/gif','image/jpg','image/jpeg','image/png'];
		var fileList = [];

		for(var i = 0; i < o.options.files.files.length; i++)
		{
			if(jQuery.inArray(o.options.files.files[i]['type'],accepted) != -1)
			{
				fileList[i] = o.options.files.files[i];
			}
		}

		if(o.options.files !== undefined){
			ajax(getFormData(fileList));
		}
    };
    
}(app));

