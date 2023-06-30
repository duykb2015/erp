$(document).ready(function () {

	//Example 2
	$("#image-upload").filer({
		limit: 1,
		maxSize: 10,
		fileMaxSize: 10,
		extensions: null,
		changeInput: '<div class="jFiler-input-dragDrop"><div class="jFiler-input-inner"><div class="jFiler-input-icon"><i class="icon-jfi-cloud-up-o"></i></div><div class="jFiler-input-text"><h3>Kéo và thả tệp vào đây</h3> <span style="display:inline-block; margin: 15px 0"> hoặc </span></div><a class="jFiler-input-choose-btn blue">Chọn tệp</a></div></div>',
		showThumbs: true,
		theme: "dragdropbox",
		templates: {
			box: '<ul class="jFiler-items-list jFiler-items-grid"></ul>',
			item: '<li class="jFiler-item">\
						<div class="jFiler-item-container">\
							<div class="jFiler-item-inner">\
								<div class="jFiler-item-thumb">\
									<div class="jFiler-item-status"></div>\
									<div class="jFiler-item-thumb-overlay">\
										<div class="jFiler-item-info">\
											<div style="display:table-cell;vertical-align: middle;">\
												<span class="jFiler-item-title"><b title="{{fi-name}}">{{fi-name}}</b></span>\
												<span class="jFiler-item-others">{{fi-size2}}</span>\
											</div>\
										</div>\
									</div>\
									{{fi-image}}\
								</div>\
								<div class="jFiler-item-assets jFiler-row">\
									<ul class="list-inline pull-left">\
										<li>{{fi-progressBar}}</li>\
									</ul>\
									<ul class="list-inline pull-right">\
										<li><a class="icon-jfi-trash jFiler-item-trash-action"></a></li>\
									</ul>\
								</div>\
							</div>\
						</div>\
					</li>',
			itemAppend: '<li class="jFiler-item">\
							<div class="jFiler-item-container">\
								<div class="jFiler-item-inner">\
									<div class="jFiler-item-thumb">\
										<div class="jFiler-item-status"></div>\
										<div class="jFiler-item-thumb-overlay">\
											<div class="jFiler-item-info">\
												<div style="display:table-cell;vertical-align: middle;">\
													<span class="jFiler-item-title"><b title="{{fi-name}}">{{fi-name}}</b></span>\
													<span class="jFiler-item-others">{{fi-size2}}</span>\
												</div>\
											</div>\
										</div>\
										{{fi-image}}\
									</div>\
									<div class="jFiler-item-assets jFiler-row">\
										<ul class="list-inline pull-left">\
											<li><span class="jFiler-item-others">{{fi-icon}}</span></li>\
										</ul>\
										<ul class="list-inline pull-right">\
											<li><a class="icon-jfi-trash jFiler-item-trash-action"></a></li>\
										</ul>\
									</div>\
								</div>\
							</div>\
						</li>',
			progressBar: '<div class="bar"></div>',
			itemAppendToEnd: false,
			canvasImage: true,
			removeConfirmation: true,
			_selectors: {
				list: '.jFiler-items-list',
				item: '.jFiler-item',
				progressBar: '.bar',
				remove: '.jFiler-item-trash-action'
			}
		},
		dragDrop: {
			dragEnter: null,
			dragLeave: null,
			drop: null,
			dragContainer: null,
		},
		uploadFile: {
			url: '/user/image/upload',
			data: null,
			type: 'POST',
			enctype: 'multipart/form-data',
			synchron: true,
			beforeSend: function () { },
			success: function (data, itemEl, listEl, boxEl, newInputEl, inputEl, id) {
				window.localStorage.setItem('img-name', data)
				var parent = itemEl.find(".jFiler-jProgressBar").parent(),
					new_file_name = data//JSON.parse(),
					filerKit = inputEl.prop("jFiler");

				filerKit.files_list[id].name = new_file_name;

				itemEl.find(".jFiler-jProgressBar").fadeOut("slow", function () {
					$("<div class=\"jFiler-item-others text-success\"><i class=\"icon-jfi-check-circle\"></i> Thành công</div>").hide().appendTo(parent).fadeIn("slow");
				});
			},
			error: function (el) {
				var parent = el.find(".jFiler-jProgressBar").parent();
				el.find(".jFiler-jProgressBar").fadeOut("slow", function () {
					$("<div class=\"jFiler-item-others text-error\"><i class=\"icon-jfi-minus-circle\"></i> Thất bại</div>").hide().appendTo(parent).fadeIn("slow");
				});
			},
			statusCode: null,
			onProgress: null,
			onComplete: null
		},
		files: null,
		addMore: false,
		allowDuplicates: true,
		clipBoardPaste: true,
		excludeName: null,
		beforeRender: null,
		afterRender: null,
		beforeShow: null,
		beforeSelect: null,
		onSelect: null,
		afterShow: null,
		onRemove: function (itemEl, file, id, listEl, boxEl, newInputEl, inputEl) {
			var filerKit = inputEl.prop("jFiler"),
				file_name = filerKit.files_list[id].name;

			$.post('/user/image/remove', { file: file_name });
		},
		onEmpty: null,
		options: null,
		dialogs: {
			alert: function (text) {
				return alert(text);
			},
			confirm: function (text, callback) {
				confirm(text) ? callback() : null;
			}
		},
		captions: {
			button: "Chọn ảnh",
			feedback: "Chọn ảnh để tải lên",
			feedback2: "Ảnh đã được chọn",
			drop: "Thả ảnh vào đây để tải lên",
			removeConfirmation: "Bạn có chắc là muốn xoá ảnh này?",
			errors: {
				filesLimit: "Tối đa chỉ được tải lên {{fi-limit}} ảnh.",
				filesType: "Chỉ hộ trợ tải lên hình ảnh.",
				filesSize: "{{fi-name}} quá lớn, dung lượng tối đa mà ảnh có thể tải lên là {{fi-fileMaxSize}} MB.",
				filesSizeAll: "Tệp bạn tải lên quá lớn, dung lượng tối đa mà ảnh có thể tải lên là {{fi-maxSize}} MB.",
				folderUpload: "Bạn không được phép tải thư mục lên."
			}
		}
	});



})
