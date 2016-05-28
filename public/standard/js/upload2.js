var total_size;//size of all loaded files.
var size_loaded;//size of all files loaded at a time given.



var XMLHttpTypes = [
    function () {return new XMLHttpRequest()},
   // function () {return new ActiveXObject("Msxml2.XMLHTTP")},
    //function () {return new ActiveXObject("Msxml3.XMLHTTP")},
    //function () {return new ActiveXObject("Microsoft.XMLHTTP")}
];

function createXMLObject() {
    var xml = false;
    for (var i=0;i<XMLHttpTypes.length;i++) {
        try {
            xml = XMLHttpTypes[i]();
        }
        catch (e) {
            continue;
        }
        break;
    }
    return xml;
}



$(document).ready(function(){
	/*upload form config*/
	$('.select_trigger').click(function(){
		if(!$(this).attr('disabled'))
		{
			$('#file_input').click();
		}
	});
	/*upload form config*/
	
	
	var upload_form = $('#upload_form'),
		file_input = $('#file_input'),
        file_list = $('#file_list'),
        submit_btn = $('#submit_btn'),
        pause_btn = $('.pause'),
        play_btn = $('.play'),
		uploaders = [];

    file_input.on('change', onFilesSelected);
	upload_form.on('submit', onFormSubmit);

 
    /**
     * Loops through the selected files, displays their file name and size
     * in the file list, and enables the submit button for uploading.
     */
    function onFilesSelected(e) {
		var ftime = Date.now();
		total_size = 0;
		size_loaded = 0;
		uploaders = [];

        var files = e.target.files,
			file,
			list_item,
			uploader;
		
		file_list.html('');

        for (var i = 0; i < files.length; i++) {
			file = files[i];
			uploader = new ChunkedUploader(file,i,ftime);
			uploaders.push(uploader);
            list_item = $('<li><span class="glyphicon glyphicon-paperclip"></span> ' + file.name + '(' + file.size.formatBytes() + ')</li>').data('uploader', uploader);
			file_list.append(list_item);
			total_size+=file.size;
        }
		
        file_list.show();
		$('.files').show();
        submit_btn.attr('disabled', false);
    }

	/**
     * Loops through all known uploads and starts each upload
     * process, preventing default form submission.
     */
    function onFormSubmit(e) {
		pause_btn.attr('disabled', false);
		submit_btn.attr('disabled', true);
		uploaders[0].start(uploaders);
		uploaders = [];
        e.preventDefault();
    }
});



function ChunkedUploader(file, i, ftime, options) {
    if (!this instanceof ChunkedUploader) {
        return new ChunkedUploader(file, i, options);
    }
 
    this.file = file;

    this.options = $.extend({
        url: $('#aup').val() + 'transfer',
		time: Date.now() + parseInt(i),
		ftime: ftime
    }, options);

    this.file_size = this.file.size;
    this.chunk_size = (1024 * 1000); // 1MB
    this.range_start = 0;
    this.range_end = this.chunk_size;
	this.file_type = this.file.type;
	this.file_name = this.file.name;
	this.brothers;
	this.ord = i;

    if ('mozSlice' in this.file) {
        this.slice_method = 'mozSlice';
    }
    else if ('webkitSlice' in this.file) {
        this.slice_method = 'webkitSlice';
    }
    else {
        this.slice_method = 'slice';
    }

 
    this.upload_request = createXMLObject();
}

ChunkedUploader.prototype = {
 
// Internal Methods __________________________________________________
 
    _upload: function() {
        var self = this,
            chunk;
 
        // Slight timeout needed here (File read / AJAX readystate conflict?)
        setTimeout(function() {
            // Prevent range overflow
            if (self.range_end > self.file_size) {
                self.range_end = self.file_size;
            }

			self.upload_request.addEventListener("progress", self._updateProgress(self.range_end));
			/*this.upload_request.addEventListener("load", self.transferComplete);
			this.upload_request.addEventListener("error", self.transferFailed);
			this.upload_request.addEventListener("abort", self.transferCanceled);*/

			self.upload_request.onreadystatechange = function() {
				if (self.upload_request.readyState == 4 && self.upload_request.status == 200) {
					self._onChunkComplete();
				}
			}

            chunk = self.file[self.slice_method](self.range_start, self.range_end);

            self.upload_request.open('POST', self.options.url , true);
			self.upload_request.setRequestHeader('X-File-Name', self.file_name);
			self.upload_request.setRequestHeader('X-File-Size', self.file_size);
			self.upload_request.setRequestHeader('X-Chunk-Size', self.chunk_size);
			self.upload_request.setRequestHeader('X-Timestamp', self.options.time);
			self.upload_request.setRequestHeader('X-Ftimestamp', self.options.ftime);
			self.upload_request.setRequestHeader('Content-Type', self.file_type);
 
            if (self.range_start !== 0) {
                self.upload_request.setRequestHeader('Content-Range', 'bytes ' + self.range_start + '-' + self.range_end + '/' + self.file_size);
            }

            self.upload_request.send(chunk);
 
        }, 200);
    },
 
// Event Handlers ____________________________________________________
 
    _onChunkComplete: function() {
        // If the end range is already the same size as our file, we
        // can assume that our last chunk has been processed and exit
        // out of the function.
        if (this.range_end === this.file_size) {
            this._onUploadComplete();
            return;
        }
        // Update our ranges
        this.range_start = this.range_end;
        this.range_end = this.range_start + this.chunk_size;
 
        // Continue as long as we aren't paused
        if (!this.is_paused) {
            this._upload();
        }
    },

	_onUploadComplete: function() {
		i = this.ord + 1;
		this.brothers[this.ord].delete;
		if(this.brothers[i])
		{
			this.brothers[i].start(this.brothers);
		}
	},

	_updateProgress: function(chunk_end){
		var _this = this;
		if(chunk_end === this.file_size)
		{
			chunk_end = chunk_end - this.range_start;
			size_loaded+=chunk_end;
		}
		else
		{
			size_loaded+=this.chunk_size;
		}


		var percentComplete = (size_loaded / total_size) * 100;
		$('.progress-bar').css({"width" : percentComplete.toFixed(0)+"%"});
		$('.progress .sr-only').text(percentComplete.toFixed(0) + "%");
		
		if(size_loaded == total_size)//if upload has finsihed, we have to reset the form, get it ready for a new upload.
		{
			this._resetForm($('#file_input'));
			setTimeout(function(){
				$('.progress .sr-only').html('');
				$('#file_list').html("<span class='glyphicon glyphicon-ok text-green'></span>");
				$('.progress-bar').css({"width" : "0%"});

				var audio = new Audio('public/standard/audio/ding.mp3');
				audio.play();

				jQuery(".select_trigger").attr('disabled', false);
				_this._save();
			},2000);
		}
	},

	_resetForm: function (e) {
		e.wrap('<form>').closest('form').get(0).reset();
		e.unwrap();

		$('#submit_btn').attr('disabled', true);
		$('.pause').attr('disabled', true);
	},
	_save: function(){
		$.ajax({
		   url: $('#aup').val() + 'save',
		   data: {ftime : this.options.ftime},
		   dataType: 'text',
		   type: 'POST'
		});
	},
 
// Public Methods ____________________________________________________
 
    start: function(array) {
		this.brothers = array;
		this._upload();
		
		$(".select_trigger").attr('disabled', true);
		var _this = this;
		$('.pause').on('click', function(){
			_this.pause();	
		});
		$('.play').on('click', function(){
			_this.resume();
		});
    },
 
    pause: function() {
        this.is_paused = true;
		$('.pause').addClass('hide-obj');
		$('.play').removeClass('hide-obj');
    },
 
    resume: function() {
        this.is_paused = false;
		
		$('.pause').removeClass('hide-obj');
		$('.play').addClass('hide-obj');

        this._upload();
    }
};