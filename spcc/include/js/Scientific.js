(function() {
  var deletedFac, deletedImage, displayXMLObj, gotAttributeData, gotAttributes, gotEquipment, gotFacImage, gotFacs, gotImages, gotInspections, gotOption, gotProcessFacs, myJax, refresh, setAddress, setAddresses, setCompany, setUser, updatedXML;
  /**
   *get group id from the url
   *
   */
  this.gup = function(name) {
    var regex, regexS, results;
    name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
    regexS = "[\\?&]" + name + "=([^&#]*)";
    regex = new RegExp(regexS);
    results = regex.exec(window.location.href);
    if (results === null) {
      return "";
    } else {
      return results[1];
    }
  };

  /**
   * make ajax request
   *
   */
  myJax = function(post, func, html) {
    return $.ajax('include/php/data.php', {
      type: 'POST',
      data: post,
      dataType: 'html',
      error: function(jqXHR, textStatus, errorThrown) {
        return console.log(textStatus);
      },
      success: function(data, textStatus, jqXHR) {
        var fun, _i, _len, _results;
        _results = [];
        for (_i = 0, _len = func.length; _i < _len; _i++) {
          fun = func[_i];
          if (html) {
            _results.push(fun(data));
          } else {
            _results.push(fun($.parseJSON(data)));
          }
        }
        return _results;
      }
    });
  };

  /**
   * removes the current company and gets a new company by company id
   *
   */
  this.changeCompanies = function(ele) {
    var data;
    $('#company_id').remove();
    if ($(ele).val() !== '0') {
      data = {
        'company_id': $(ele).val(),
        'type': 'getCompany'
      };
      return myJax(data, [setCompany, setAddresses], false);
    }
  };

  /**
   * sets the company name and phone
   *
   */
  setCompany = function(data) {
    $('#name').val(data.company.name);
    $('#phone_area').val(data.phone.area_code);
    $('#phone_pre').val(data.phone.prefix);
    $('#phone_post').val(data.phone.sufix);
    $('#phone_ext').val(data.phone.ext);
    return $('#type').after(' <input type="hidden" name="company_id" id="company_id" value="' + data.company.id + '"> ');
  };

  /**
   * calls the functions that set the company address
   *
   */
  setAddresses = function(data) {
    setAddress(data.address_one, 'p');
    return setAddress(data.address_two, 'm');
  };

  /**
   * sets the actual company address
   *
   */
  setAddress = function(data, ext) {
    $('#' + ext + '_address_one').val(data.address_1);
    $('#' + ext + '_address_two').val(data.address_2);
    $('#' + ext + '_city').val(data.city);
    $('#' + ext + '_state').val(data.state);
    $('#' + ext + '_zipcode_prefix').val(data.zipcode);
    return $('#' + ext + '_zipcode_sufix').val(data.sufix);
  };

  /**
   * removes the current user information and gets the new user information
   *
   */
  this.changeUsers = function(ele) {
    var data;
    $('#user_id').remove();
    if ($(ele).val() !== '0') {
      data = {
        'user_id': $(ele).val(),
        'type': 'getUser'
      };
      return myJax(data, [setUser], false);
    }
  };

  /**
   * set the user data
   *
   */
  setUser = function(data) {
    $('#type').after(' <input type="hidden" name="user_id" id="user_id" value="' + data.user.id + '"> ');
    $('#username').val(data.user.name);
    return $('#usertype').val(data.user.type);
  };

  /**
   * deletes a user
   *
   */
  this.deleteRecord = function(type) {
    var data, ele, id, rtype;
    if (type === 'user') {
      ele = 'user_id';
      rtype = 'deleteUser';
    } else {
      ele = 'company_id';
      rtype = 'deleteCompany';
    }
    id = parseInt($('#' + ele).val());
    if (id > 0) {
      data = {
        'id': id,
        'type': rtype
      };
      return myJax(data, [refresh], false);
    }
  };

  /**
   * refreshs the current page
   *
   */
  refresh = function(data) {
    if (data.result === 'true') {
      return window.location.reload();
    }
  };

  /**
   * adds a facility element to the page
   *
   */
  this.addFacility = function() {
    return $('#facTable').append(
			'<tr>' +
				'<td><label for="name" >Facility Name :  </label></td>' + 
				'<td><input type="text" name="facility[]" value=""/></td>' + 
				'<td><input type="hidden" name="facility_id[]" value="0"/></td>' + 
			'</tr>');
  };
	/**
	 * get the facilities from the server
	 *
	 */
  this.getFacilities = function(ele) {
    var data, id;
    id = parseInt($(ele).val());
    if (id > 0) {
      data = {
        'company_id': id,
        'type': 'getFacilities'
      };
      return myJax(data, [gotFacs], false);
    }
  };

	/**
	 * sets the facility elements to the page
	 *
	 */
  gotFacs = function(data) {
    var x, _i, _len, _results;
    $('#facTable').empty();
    _results = [];
    for (_i = 0, _len = data.length; _i < _len; _i++) {
      x = data[_i];
      _results.push($('#facTable').append(
				'<tr>' + 
				  '<td><label for="name" >Facility Name :  </label></td>' + 
				  '<td><input type="text" name="facility[]" value="' + x.name + '"/></td>' + 
				  '<td><input type="hidden" name="facility_id[]" value="' + x.id + '"/>' + 
					'<img src="include/image/delete.png" onclick="deleteFacilityBox(this, ' + x.id + ')" /></td>' + 
				'</tr>'));
    }
    return _results;
  };

	/**
	 * a different get facilites function from the process page
	 * TODO merge this function with the previous get facilities function
	 *
	 */
  this.getProcessFacilities = function(ele) {
    var data, id;
    id = parseInt($(ele).val());
    if (id > 0) {
      data = {
        'company_id': id,
        'type': 'getFacilities'
      };
      return myJax(data, [gotProcessFacs], false);
    }
  };

	/**
	 * a different got facilites function from the process page
	 * TODO merge this function with the previous got facilities function
	 *
	 */
  gotProcessFacs = function(data) {
    var x, _i, _len, _results;
    $('#fac_select').empty();
    _results = [];
    for (_i = 0, _len = data.length; _i < _len; _i++) {
      x = data[_i];
      _results.push($('#fac_select').append('<option value="' + x.id + '">' + x.name + '</option>'));
    }
    return _results;
  };

	/**
	 * get inspections from the web server
	 *
	 *
	 */
  this.getInspections = function(ele) {
    var data, id;
    id = parseInt($(ele).val());
    if (id > 0) {
      data = {
        'id': id,
        'type': 'getInspections'
      };
      return myJax(data, [gotInspections], false);
    }
  };

	/**
	 * take a list of inspections from the web server and display them as options
	 *
	 *
	 */
  gotInspections = function(data) {
    var x, _i, _len, _results;
    if (data === null) {
      return;
    }
    console.log(data);
    $('#ins_select').empty();
    $('#ins_select').append('<option value="null"></option>');
    _results = [];
    for (_i = 0, _len = data.length; _i < _len; _i++) {
      x = data[_i];
      _results.push($('#ins_select').append(
				  '<option value="' + x.data_path + '">' + x.timestamp + '</option>'));
    }
    return _results;
  };

	/**
	 * get the images from the web server for the facility
	 *
	 *
	 */
  this.getFacImage = function(ele) {
    var data, id;
    id = parseInt($(ele).val());
    if (id > 0) {
      data = {
        'company_id': id,
        'type': 'getFacilities'
      };
      return myJax(data, [gotFacImage], false);
    }
  };

	/**
	 * create elements from the images from the webserver
	 *
	 *
	 */
  gotFacImage = function(data) {
    var str, x, _i, _len;
    $('#facility_id').empty();
    $('#carousel').html('<ul id="mycarousel" class="jcarousel-skin-tango"></ul>');
    $('#image').html('</br><input type="file" id="image0" name="file0">');
    $('#facility_id').html('<option value="0"></option>');
    for (_i = 0, _len = data.length; _i < _len; _i++) {
      x = data[_i];
      str = '<option value="' + x.id + '">' + x.name + '</option>';
      $('#facility_id').append(str);
    }
    return $('#mycarousel').jcarousel();
  };

	/**
	 * delete a facility on the web server
	 *
	 *
	 */
  this.deleteFacility = function(ele, id) {
    var data;
    if (id > 0) {
      $(ele).parent().parent().remove();
      data = {
        'id': id,
        'type': 'deleteFacility'
      };
      return myJax(data, [deletedFac], false);
    }
  };

	/**
	 * delete a facility on the page
	 *
	 *
	 */
  deletedFac = function(data) {
    if (data.result === 'true') {
      return;
    }
  };

	/**
	 * add an image upload element to the page 
	 *
	 *
	 */
  this.addImage = function() {
    var a;
    a = $('#image').find('input');
    return $('#image').append('</br><input type="file" id="image' + a.length + '" name="file' + a.length + '">');
  };

	/**
	 * get images from the web server
	 *
	 *
	 */
  this.getImages = function(ele) {
    var data, id;
    id = $(ele).val();
    if (id > 0) {
      data = {
        'id': id,
        'type': 'getImages'
      };
      return myJax(data, [gotImages], false);
    }
  };

	/**
	 * create elements out of images from the web server
	 *
	 *
	 */
  gotImages = function(data) {
    var str, x, _i, _len;
    $('#carousel').html('<ul id="mycarousel" class="jcarousel-skin-tango"></ul>');
    for (_i = 0, _len = data.length; _i < _len; _i++) {
      x = data[_i];
      str = '<li><img src="' + x.data_path + '" width="75" height="75" onclick="deleteImage(this, ' + x.id + ')"/></li>';
      $('#mycarousel').append(str);
    }
    return $('#mycarousel').jcarousel();
  };

  this.deleteImage = function(ele, id) {
    var data;
    if (id > 0) {
      data = {
        'id': id,
        'type': 'deleteImage'
      };
      return myJax(data, [deletedImage], false);
    }
  };

  deletedImage = function(data) {
    if (data.result === 'true') {
      return $(ele).parent().remove();
    }
  };

  this.storeEquipment = function(ele) {
    return $('#equip_name').val($(ele).find('option:selected').text());
  };

  this.getAttributes = function(ele) {
    var data, id;
    id = $(ele).val();
    if (id > 0) {
      data = {
        'id': id,
        'type': 'getAttributes'
      };
      return myJax(data, [gotAttributes], false);
    }
  };

  gotAttributes = function(data) {
    var a, a_ele, e, e_ele, x, _i, _j, _k, _len, _len1, _len2, _ref;
    a_ele = $('[name="attr_id"]');
    for (_i = 0, _len = a_ele.length; _i < _len; _i++) {
      a = a_ele[_i];
      $(a).empty();
      $(a).append('<option value="0" ></option>');
      for (_j = 0, _len1 = data.length; _j < _len1; _j++) {
        x = data[_j];
        if ($(a).attr("type") === "edit") {
          $(a).append('<option value="' + x.id + '" >' + x.name + '</option>');
        } else {
          if ((_ref = x.type) === "select" || _ref === "check" || _ref === "radio") {
            $(a).append('<option value="' + x.id + '" >' + x.name + '</option>');
          }
        }
      }
    }
    e_ele = $('[name="equip_id"]');
    for (_k = 0, _len2 = e_ele.length; _k < _len2; _k++) {
      e = e_ele[_k];
      $(e).val($('#equip_id').val());
    }
    $('#equip_name').val($("#equip_id option:selected").text());
    return $('#parent_equip_id').val($("#equip_id option:selected").attr('parent'));
  };

  this.getEquipment = function(ele) {
    var data, m, m_ele, type, _i, _len;
    type = $(ele).val();
    if (type !== '') {
      m_ele = $('[name="model_type"]');
      for (_i = 0, _len = m_ele.length; _i < _len; _i++) {
        m = m_ele[_i];
        $(m).val(type);
      }
      data = {
        'model_type': type,
        'type': 'getEquipment'
      };
      return myJax(data, [gotEquipment], false);
    }
  };

  gotEquipment = function(data) {
    var ele, p_ele, x, _i, _len, _results;
    ele = $('#equip_id');
    p_ele = $('#parent_equip_id');
    $(ele).empty();
    $(ele).append('<option value="0" ></option>');
    $(p_ele).empty();
    $(p_ele).append('<option value="0" ></option>');
    _results = [];
    for (_i = 0, _len = data.length; _i < _len; _i++) {
      x = data[_i];
      $(ele).append('<option value="' + x.id + '" parent="' + x.parent + '">' + x.name + '</option>');
      _results.push($(p_ele).append('<option value="' + x.id + '" >' + x.name + '</option>'));
    }
    return _results;
  };

  this.getAttributeData = function(ele) {
    var data, id;
    id = $(ele).val();
    if (id > 0) {
      data = {
        'id': id,
        'type': 'getAttribute'
      };
      return myJax(data, [gotAttributeData], false);
    }
  };

  gotAttributeData = function(data) {
    $('#attr_name').val(data.name);
    $('#attr_text').val(data.text);
    return $('#attr_type').val(data.type);
  };

  this.addOption = function() {
    return $('#optionTable').append('<tr>\
                                  <td><label for="name" >Edit/Add Option Text :  </label></td>\
                                  <td><input id="opt_text" name="opt_text[]" value=""/></td>\
                              </tr>');
  };

  this.getOptions = function(ele) {
    var data, id;
    id = $(ele).val();
    if (id > 0) {
      data = {
        'id': id,
        'type': 'getOptions'
      };
      return myJax(data, [gotOption], false);
    }
  };

  gotOption = function(data) {
    var x, _i, _len, _results;
    $('#optionTable').empty();
    if (data.length === 0) {
      return $('#optionTable').append('<tr>\
                                           <td><label for="name" >Edit/Add Option Text :  </label></td>\
                                           <td><input id="opt_text" name="opt_text[]" value=""/></td>\
                                           <td></td>\
                                      </tr>');
    } else {
      _results = [];
      for (_i = 0, _len = data.length; _i < _len; _i++) {
        x = data[_i];
        _results.push($('#optionTable').append('<tr>\
                                          <td><label for="name" >Edit/Add Option Text :  </label></td>\
                                          <td><input id="opt_text" name="opt_text[]" value="' + x.text + '"/></td>\
                                          <td><img src="include/image/delete.png" onclick="deleteOption(this, ' + x.id + ')" /></td>\
                                     </tr>'));
      }
      return _results;
    }
  };

  this.deleteOption = function(ele, id) {
    var data;
    if (id > 0) {
      $(ele).parent().parent().remove();
      data = {
        'id': id,
        'type': 'deleteOption'
      };
      return myJax(data, [console.log], false);
    }
  };

  this.deleteAttribute = function() {
    var data, id;
    id = $('#attr_id').val();
    if (id > 0) {
      data = {
        'id': id,
        'type': 'deleteAttribute'
      };
      return myJax(data, [refresh], false);
    }
  };

  this.deleteEquipment = function() {
    var data, id;
    id = $('#equip_id').val();
    console.log(id);
    if (id > 0) {
      data = {
        'id': id,
        'type': 'deleteEquipment'
      };
      return myJax(data, [refresh], false);
    }
  };

  this.getXMLObj = function(ele) {
    var data, data_path, parent;
    if ($(ele).is("select")) {
      data_path = $(ele).val();
      localStorage.setItem("data_path", data_path);
    } else {
      data_path = localStorage.getItem("data_path");
    }
    parent = $(ele).attr("parent");
    if (data_path !== 'null') {
      data = {
        'data_path': data_path,
        'parent_id': parent,
        'type': 'getXMLObj'
      };
      return myJax(data, [displayXMLObj], false);
    }
  };

  displayXMLObj = function(data) {
    var answer, equip, func, parent, parent_box, str, x, y, _i, _j, _k, _l, _len, _len1, _len2, _len3, _ref, _ref1, _ref2, _results;
    func = 'updateXML(this)';
    $('#data_path').remove();
    $('.equipment_box').remove();
    parent_box = $('.parent_box');
    for (_i = 0, _len = parent_box.length; _i < _len; _i++) {
      parent = parent_box[_i];
      if ($(parent).val() === data.parent.type) {
        $(parent).remove();
      }
    }
	//console.log(data);
    localStorage.setItem("parent_id", data.parent.id);
    equip = $('#equip_box').find('fieldset');
    $(equip[0]).append('<input class="parent_box" type="button" onclick="getXMLObj(this)" parent="' + data.parent.id + '" value="' + data.parent.type + '">');
    _ref = data.child;
    for (_j = 0, _len1 = _ref.length; _j < _len1; _j++) {
      x = _ref[_j];
      $(equip[1]).append('<input class="equipment_box" type="button" onclick="getXMLObj(this)" parent="' + x.id + '" value="' + x.type + '">');
    }
    $('#question_table').empty();
    _ref1 = data.question;
    _results = [];
    for (_k = 0, _len2 = _ref1.length; _k < _len2; _k++) {
      x = _ref1[_k];
      str = "<tr><td>" + x.text + "</td><td>";
      if (x.options.length > 0) {
        str += '<select name="' + x.name + '" onchange="' + func + '">';
        _ref2 = x.options;
        for (_l = 0, _len3 = _ref2.length; _l < _len3; _l++) {
          y = _ref2[_l];
		  s = ''
		  if(y.text == x.answer){
			s = 'selected="selected"'
		  }
          str += '<option '+ s +' value="' + y.text + '">' + y.text + '</option>';
        }
        str += '</select>';
      } else {
        if (x.answer === null) {
          answer = '';
        } else {
          answer = x.answer;
        }
        str += '<input name="' + x.name + '" onblur="' + func + '" value="' + answer + '"/>';
      }
      str += '</td></tr>';
      _results.push($('#question_table').append(str));
    }
    return _results;
  };

  this.updateXML = function(ele) {
    var data, data_path, id, name, value;
    id = localStorage.getItem("parent_id");
    value = $(ele).val();
    name = $(ele).attr('name');
    data_path = localStorage.getItem("data_path");
    if (value !== '') {
      data = {
        'id': id,
        'type': 'updateXML',
        'value': value,
        'name': name,
        'data_path': data_path
      };
      return myJax(data, [updatedXML], false);
    }
  };

  updatedXML = function(data) {
    if (data.result === 'true') {
      return console.log(data.result);
    } else {
      return alert('Data was not saved');
    }
  };

  getSPCC = function(data) {
	var data, data_path, id, name, value;
    value = $(data).val();

	var spcclocation = '../spcc/word/SPCCDX.php?ref='+value;
	window.open(spcclocation);
  };

}).call(this);
