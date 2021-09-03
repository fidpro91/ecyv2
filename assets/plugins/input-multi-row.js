(function($)
{
  var num = 0;
  $.fn.inputMultiRow = function(options) 
  {
    // console.log(options);
    var divku = this;
    var nama = $(divku).attr('class').split(" ")[0]
    var tb = 
  '<button type="button" class="btn btn-info pull-right btnplus_'+nama+'"><i class ="fa fa-plus"></i></button><table class="table tb_'+nama+'" ><thead></thead><tbody></tbody></table';
    this.html(tb);
    var header = "<tr>";
    // options.column();
    var jsonCol = options.column();
    $.each(jsonCol,(ind,obj)=>{
      header += "<th>"+obj.label+"</th>";
    });
    header += "<th>#</th></tr>";
    this.closest('div').find(".tb_"+nama+" > thead").append(header);

    if (options.data) {
        $.each(options.data,function(key,objek){
          var row = "<tr class=\"row_"+nama+"\">";
          $.each(jsonCol,(ind,obj)=>{
              var attr="";
              if (obj.attr) {
                  $.each(obj.attr,function(i,o){
                    attr += " "+i+"=\""+0+"\"";
                  });
              }
              if (obj.type == 'text') {
                  row += "<td><input type=\"text\" name=\""+nama+"["+key+"]["+obj.id+"]\" class=\"form-control input-sm "+obj.id+"\" value=\""+objek[obj.id]+"\" "+attr+"/></td>";
              }else if(obj.type == 'autocomplete'){
                  row += "<td><input type=\"text\" class=\"form-control input-sm autocom_"+obj.id+"\" value=\""+objek["label_"+obj.id]+"\"/><input type=\"hidden\" name=\""+nama+"["+key+"]["+obj.id+"]\" class=\"form-control input-sm "+obj.id+"\" value=\""+objek[obj.id]+"\"/></td>";
              }else if(obj.type == 'select'){
                  row += "<td><select name=\""+nama+"["+key+"]["+obj.id+"]\" class=\"form-control input-sm "+obj.id+"\" "+attr+">";
                  var selected = "";
                  $.each(obj.data,function(a,b){
                    if (b.id == objek[obj.id]) {
                      selected = "selected";
                    }
                    row += "<option "+selected+" value=\""+b.id+"\">"+b.text+"</option>";
                  });
                  row += "</select></td>";
              }else if(obj.type == 'custom'){
                  row += "<td>"+obj.element+"</td>";
                  alert(key);
                  $(obj.element).filter('input').each(function(){
                      $(this).attr('name',""+nama+"["+key+"]["+obj.id+"]");
                  });
              }
          });
          row += "<td><button class=\"btn btn-danger btn-xs removeItem_"+nama+"\" type=\"button\"><i class=\"fa fa-trash\"></i></button></td>";
          row += "</tr>";
          $(divku).closest('div').find(".tb_"+nama+" > tbody").append(row);
        });
    }

    this.closest('div').find(".btnplus_"+nama+"").click(()=>{
        num = $(".row_"+nama+"").length;
        var row = "<tr class=\"row_"+nama+"\">";
        $.each(jsonCol,(ind,obj)=>{
            var attr="";
            if (obj.attr) {
                $.each(obj.attr,function(i,o){
                  attr += " "+i+"=\""+0+"\"";
                });
            }
            if (obj.type == 'text') {
                row += "<td><input type=\"text\" name=\""+nama+"["+num+"]["+obj.id+"]\" class=\"form-control input-sm "+obj.id+"\" "+attr+"/></td>";
            }else if(obj.type == 'autocomplete'){
                row += "<td><input type=\"text\" class=\"form-control input-sm autocom_"+obj.id+"\" /><input type=\"hidden\" name=\""+nama+"["+num+"]["+obj.id+"]\" class=\"form-control input-sm "+obj.id+"\" /></td>";
            }else if(obj.type == 'select'){
                row += "<td><select name=\""+nama+"["+num+"]["+obj.id+"]\" class=\"form-control input-sm "+obj.id+"\" "+attr+">";
                $.each(obj.data,function(a,b){
                  row += "<option value=\""+b.id+"\">"+b.text+"</option>";
                });
                row += "</select></td>";
            }else if(obj.type == 'custom'){
                var element = "<"+obj.element[0];
                $.each(obj.element[1],function(ind,val){
                  element += " "+ind+'="'+val+'"';
                });
                element += "name=\""+nama+"["+num+"]["+obj.id+"]\" />";
                row += "<td>"+element+"</td>"; 
              }
        });
        row += "<td><button class=\"btn btn-danger btn-xs removeItem_"+nama+"\" type=\"button\"><i class=\"fa fa-trash\"></i></button></td>";
        row += "</tr>";
      $(divku).closest('div').find(".tb_"+nama+" > tbody").append(row);

      if (options.extension) {
        // console.log(options.extension);
        $.each(options.extension,function(key,obj){
          if (typeof obj === "object") {
            $.each(obj,function(i,o){
              $(key)[i](o);
            });
          }
        })
        // $("[data-inputmask]")[options.extension]();
      }
      /*$("[data-toggle=\"toggle\"]").bootstrapToggle();*/
      });

    $('body').on('click','.removeItem_'+nama+'',function() 
    {
        $(this).closest('tr').remove();
        $(divku).closest('div').find(".row_"+nama+"").each(function(index) {
          // $(this).find("td:first").html(index+1);
          var prefix = ""+nama+"[" + index + "]";
          $(this).find("textarea, select, input").each(function() {
            this.name = this.name.replace(/dt\[\d+\]/, prefix);  
          });
        });
    })
  }
})(jQuery)