@gup = ( name ) ->
    name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]")
    regexS = "[\\?&]"+name+"=([^&#]*)"
    regex = new RegExp( regexS );
    results = regex.exec( window.location.href );
    if results == null
        ""
    else
        results[1]

myJax = (post, func, html)->
    $.ajax 'include/php/data.php',
        type: 'POST'
        data: post
        dataType: 'html'
        error: (jqXHR, textStatus, errorThrown) ->
            console.log textStatus
        success: (data, textStatus, jqXHR) ->
            for fun in func
                if html
                    fun data
                else
                    fun $.parseJSON data

@changeCompanies = (ele) ->
    $('#company_id').remove();
    if $(ele).val() != '0'
        data =
        'company_id': $(ele).val(),
        'type': 'getCompany'
        myJax data, [setCompany, setAddresses], false


setCompany = (data) ->
    $('#name').val(data.company.name)
    $('#phone_area').val(data.phone.area_code)
    $('#phone_pre').val(data.phone.prefix)
    $('#phone_post').val(data.phone.sufix)
    $('#phone_ext').val(data.phone.ext)
    $('#type').after(' <input type="hidden" name="company_id" id="company_id" value="'+data.company.id+'"> ');

setAddresses = (data) ->
    setAddress data.address_one, 'p'
    setAddress data.address_two, 'm'

setAddress = (data, ext) ->
    $('#'+ext+'_address_one').val(data.address_1)
    $('#'+ext+'_address_two').val(data.address_2)
    $('#'+ext+'_city').val(data.city)
    $('#'+ext+'_state').val(data.state)
    $('#'+ext+'_zipcode_prefix').val(data.zipcode)
    $('#'+ext+'_zipcode_sufix').val(data.sufix)

@changeUsers = (ele) ->
    $('#user_id').remove();
    if $(ele).val() != '0'
        data =
            'user_id' : $(ele).val(),
            'type' : 'getUser'
        myJax data, [setUser], false

setUser = (data) ->
    $('#type').after(' <input type="hidden" name="user_id" id="user_id" value="'+data.user.id+'"> ');
    $('#username').val data.user.name
    $('#usertype').val data.user.type

@deleteRecord = (type) ->
    if type == 'user'
        ele = 'user_id';
        rtype = 'deleteUser';
    else
        ele = 'company_id';
        rtype = 'deleteCompany';

    id = parseInt $('#'+ele).val()
    if id > 0
        data =
            'id' : id,
            'type' : rtype
        myJax data, [refresh], false

refresh = (data) ->
    if data.result == 'true'
        window.location.reload();

@addFacility = ->
    $('#facTable').append('<tr>'+
                             '<td><label for="name" >Facility Name :  </label></td>'+
                             '<td><input type="text" name="facility[]" value=""/></td>'+
                             '<td><input type="hidden" name="facility_id[]" value="0"/></td>'+
                         '</tr>')

@getFacilities = (ele) ->
    id = parseInt $(ele).val()
    if id > 0
        data =
            'company_id' : id,
            'type' : 'getFacilities'
        myJax data, [gotFacs], false


gotFacs = (data) ->
    $('#facTable').empty()
    for x in data
        $('#facTable').append('<tr>'+
                                 '<td><label for="name" >Facility Name :  </label></td>'+
                                 '<td><input type="text" name="facility[]" value="'+x.name+'"/></td>'+
                                 '<td><input type="hidden" name="facility_id[]" value="'+x.id+'"/>'+
                                '<img src="include/image/delete.png" onclick="deleteFacility(this, 0)" /></td>'+
                             '</tr>')
@getProcessFacilities = (ele) ->
    id = parseInt $(ele).val()
    if id > 0
        data =
            'company_id' : id,
            'type' : 'getFacilities'
        myJax data, [gotProcessFacs], false


gotProcessFacs = (data) ->
    $('#fac_select').empty()
    for x in data
        $('#fac_select').append '<option value="'+x.id+'">'+x.name+'</option>'


@getInspections = (ele) ->
    id = parseInt $(ele).val()
    if id > 0
        data =
            'id' : id,
            'type' : 'getInspections'
        myJax data, [gotInspections], false


gotInspections = (data) ->
    if data == null
        return
    console.log data
    $('#ins_select').empty()
    $('#ins_select').append '<option value="null"></option>'
    for x in data
        $('#ins_select').append '<option value="'+x.data_path+'">'+x.timestamp+'</option>'

@getFacImage = (ele) ->
    id = parseInt $(ele).val()
    if id > 0
        data =
            'company_id' : id,
            'type' : 'getFacilities'
        myJax data, [gotFacImage], false

gotFacImage = (data) ->
    $('#facility_id').empty();
    $('#carousel').html('<ul id="mycarousel" class="jcarousel-skin-tango"></ul>');
    $('#image').html('</br><input type="file" id="image0" name="file0">');
    $('#facility_id').html('<option value="0"></option>');
    for x in data
        str = '<option value="'+ x.id +'">'+ x.name +'</option>';
        $('#facility_id').append(str);
    $('#mycarousel').jcarousel();



@deleteFacility = (ele, id) ->
    if id > 0
        $(ele).parent().parent().remove();
        data =
            'id' : id,
            'type' : 'deleteFacility'
        myJax data, [deletedFac], false

deletedFac = (data) ->
    if data.result == 'true'
        for i,v of $('tr')
            for index, value of $(v).find('input')
                num = i-1;
                if $(value).attr('type') == 'text'
                    $(value).attr('name', 'name' + num);
                else
                    $(value).attr('name', num);

@addImage = ->
    a = $('#image').find('input')
    $('#image').append('</br><input type="file" id="image'+a.length+'" name="file'+a.length+'">')


@getImages = (ele) ->
    id = $(ele).val();
    if id > 0
        data =
            'id' : id,
            'type' : 'getImages'
        myJax data, [gotImages], true

gotImages = (data) ->
    $('#carousel').html('<ul id="mycarousel" class="jcarousel-skin-tango"></ul>')
    for x in data
        str = '<li><img src="'+x.data_path+'" width="75" height="75" onclick="deleteImage(this, '+x.id+')"/></li>';
        $('#mycarousel').append(str);
    $('#mycarousel').jcarousel();


@deleteImage = (ele, id) ->
  if id > 0
    data =
        'id' : id,
        'type' : 'deleteImage'
    myJax data, [deletedImage], false

deletedImage = (data) ->
    if data.result == 'true'
        $(ele).parent().remove()

@storeEquipment = (ele) ->
    $('#equip_name').val($(ele).find('option:selected').text());

#Used to get attributes for the selection
@getAttributes = (ele) ->
    id = $(ele).val()
    if id > 0
        data =
            'id' : id,
            'type' : 'getAttributes'
        myJax data, [gotAttributes], false

gotAttributes = (data) ->
    a_ele = $('[name="attr_id"]')
    for a in a_ele
        $(a).empty()
        $(a).append('<option value="0" ></option>')
        for x in data
            if $(a).attr("type") == "edit"
                $(a).append('<option value="'+x.id+'" >'+x.name+'</option>')
            else
                if x.type in ["select", "check", "radio"]
                    $(a).append('<option value="'+x.id+'" >'+x.name+'</option>')


    e_ele = $('[name="equip_id"]')
    for e in e_ele
        $(e).val $('#equip_id').val()
    $('#equip_name').val $("#equip_id option:selected").text();
    $('#parent_equip_id').val $("#equip_id option:selected").attr('parent');

#Used to get equipemnt for the selection
@getEquipment = (ele) ->
    type = $(ele).val()
    if type != ''
        m_ele = $('[name="model_type"]')
        for m in m_ele
            $(m).val type
        data =
            'model_type' : type,
            'type' : 'getEquipment'
        myJax data, [gotEquipment], false

gotEquipment = (data) ->
    ele = $('#equip_id')
    p_ele = $('#parent_equip_id')
    $(ele).empty()
    $(ele).append('<option value="0" ></option>')
    $(p_ele).empty()
    $(p_ele).append('<option value="0" ></option>')

    for x in data
        $(ele).append('<option value="'+x.id+'" parent="'+x.parent+'">'+x.name+'</option>')
        $(p_ele).append('<option value="'+x.id+'" >'+x.name+'</option>')



#Used to get the details of an attribute
@getAttributeData = (ele) ->
    id = $(ele).val()
    if id > 0
        data =
            'id' : id,
            'type' : 'getAttribute'
        myJax data, [gotAttributeData], false

gotAttributeData = (data) ->
    $('#attr_name').val(data.name)
    $('#attr_text').val(data.text)
    $('#attr_type').val(data.type)

@addOption = () ->
    $('#optionTable').append('<tr>
                                  <td><label for="name" >Edit/Add Option Text :  </label></td>
                                  <td><input id="opt_text" name="opt_text[]" value=""/></td>
                              </tr>')

@getOptions = (ele) ->
    id = $(ele).val()
    if id > 0
        data =
            'id' : id,
            'type' : 'getOptions'
        myJax data, [gotOption], false

gotOption = (data) ->
    $('#optionTable').empty()
    if data.length == 0
             $('#optionTable').append('<tr>
                                           <td><label for="name" >Edit/Add Option Text :  </label></td>
                                           <td><input id="opt_text" name="opt_text[]" value=""/></td>
                                           <td></td>
                                      </tr>')
    else
        for x in data
            $('#optionTable').append('<tr>
                                          <td><label for="name" >Edit/Add Option Text :  </label></td>
                                          <td><input id="opt_text" name="opt_text[]" value="'+x.text+'"/></td>
                                          <td><img src="include/image/delete.png" onclick="deleteOption(this, '+x.id+')" /></td>
                                     </tr>')


@deleteOption = (ele, id) ->
    if id > 0
        $(ele).parent().parent().remove()
        data =
            'id' : id,
            'type' : 'deleteOption'
        myJax data, [console.log], false

@deleteAttribute = () ->
    id = $('#attr_id').val()
    if id > 0
        data =
            'id' : id,
            'type' : 'deleteAttribute'
        myJax data, [refresh], false

@deleteEquipment = () ->
    id = $('#equip_id').val()
    console.log id
    if id > 0
        data =
            'id' : id,
            'type' : 'deleteEquipment'
        myJax data, [refresh], false

@getXMLObj = (ele) ->
    if $(ele).is("select")
        data_path = $(ele).val()
        localStorage.setItem("data_path", data_path)
    else
        data_path = localStorage.getItem("data_path")
    parent = $(ele).attr "parent"
    if data_path != 'null'
        data =
            'data_path' : data_path,
            'parent_id' : parent,
            'type' : 'getXMLObj'
        myJax data, [displayXMLObj], false

displayXMLObj = (data) ->
    func= 'updateXML(this)'
    $('#data_path').remove()
    $('.equipment_box').remove()
    parent_box = $('.parent_box')
    for parent in parent_box
        if $(parent).val() == data.parent.type
            $(parent).remove()
    #$('#equip_box').append '<input id="data_path" type=hidden value="'+data.data_path+'"/>'
    console.log data
    localStorage.setItem("parent_id", data.parent.id)
    equip = $('#equip_box').find('fieldset')
    $(equip[0]).append '<input class="parent_box" type="button" onclick="getXMLObj(this)" parent="'+data.parent.id+'" value="'+data.parent.type+'">'
    for x in data.child
        $(equip[1]).append '<input class="equipment_box" type="button" onclick="getXMLObj(this)" parent="'+x.id+'" value="'+x.type+'">'

    $('#question_table').empty()
    for x in data.question
        str = "<tr><td>"+x.text+"</td><td>"
        if x.options.length > 0
            str += '<select name="'+x.name+'" onchange="'+func+'">'
            for y in x.options
                str += '<option value="'+y.text+'">'+y.text+'</option>'
            str += '</select>'
        else
            if x.answer == null
                answer = ''
            else
                answer = x.answer
            str += '<input name="'+x.name+'" onblur="'+func+'" value="'+answer+'"/>'
        str += '</td></tr>'
        $('#question_table').append(str)

@updateXML = (ele) ->
    id = localStorage.getItem("parent_id")
    value = $(ele).val()
    name = $(ele).attr 'name'
    data_path = localStorage.getItem("data_path")
    if value != ''
        data =
            'id' : id,
            'type' : 'updateXML'
            'value' : value,
            'name' : name,
            'data_path' : data_path
        myJax data, [updatedXML], false

updatedXML = (data) ->
    if data.result == 'true'
        console.log data.result
    else
        alert 'Data was not saved'