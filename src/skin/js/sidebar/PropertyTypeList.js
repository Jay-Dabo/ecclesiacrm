$(document).ready(function () {
  window.CRM.dataFundTable = $("#property-listing-table-v2").DataTable({
    ajax:{
      url: window.CRM.root + "/api/properties/propertytypelists",
      type: 'POST',
      contentType: "application/json",
      dataSrc: "PropertyTypeLists"
    },
    "language": {
      "url": window.CRM.plugin.dataTable.language.url
    },
    "order": [[ 2, "asc" ]],
    columns: [
      {
        width: 'auto',
        title:i18next.t('Actions'),
        data:'Id',
        render: function(data, type, full, meta) {
          if (full.PrtName != 'Menu') {
            var res = '<a href="' + window.CRM.root + '/PropertyTypeEditor.php?PropertyTypeID='+ full.PrtId + '"><i class="fa fa-pencil" aria-hidden="true"></i></a>';
            res += '&nbsp;&nbsp;&nbsp;<a href="' + window.CRM.root + '/PropertyTypeDelete.php?PropertyTypeID='+ full.PrtId + '&Warn"><i class="fa fa-trash-o" aria-hidden="true" style="color:red"></i></a>';
            return res;
          } else {
            return '';
          }
        }
      },      
      {
        width: 'auto',
        title:i18next.t('Name'),
        data:'PrtName',
        render: function(data, type, full, meta) {
          return data;
        }
      },
      {
        width: 'auto',
        title:i18next.t('Class'),
        data:'PrtClass',
        render: function(data, type, full, meta) {
          if (full.PrtName == 'Menu') {
            return i18next.t("Sunday School Sub Menu");
          } else {
            return i18next.t(data);
          }
        }
      },
      {
        width: 'auto',
        title:i18next.t('Description'),
        data:'PrtDescription',
        render: function(data, type, full, meta) {
          return data;
        }
      }
    ],
    responsive: true,
    createdRow : function (row,data,index) {
      $(row).addClass("listRow");
    }
  });
  
  
  /* IMPORTANT : be careful
       This will work in cartToGroup code */
    function BootboxContentFundList(){    
      var frm_str = '<div class="box-body">'
        +'<div class="row">'
        +'  <div class="col-lg-2">'
        +'    <label for="depositComment">'+i18next.t("Active")+'</label>'
        +'    <input id="activCheckbox" type="checkbox" name="activ" id="activ" checked="checked">'
        +'  </div>'
        +'  <div class="col-lg-1">'
        +'    <label for="depositDate">'+i18next.t("Name")+'</label>'
        +'  </div>'
        +'  <div class="col-lg-9">'
        +'    <input class="form-control input-md" name="Name" id="Name" style="width:100%">'
        +'  </div>'
        +'</div>'
        +'<div class="row">'
        +'  <div class="col-lg-2">'
        +'    <label for="depositDate">'+i18next.t("Description")+'</label>'
        +'  </div>'
        +'  <div class="col-lg-10">'
        +'    <input class="form-control input-md" name="description" id="description" style="width:100%">'
        +'  </div>'
        +'</div>'
      +'</div>';

        var object = $('<div/>').html(frm_str).contents();

        return object
    }
    
  $(document).on("click",".delete-fund", function(){
     var fundId = $(this).data("id");
     
     bootbox.confirm({
      title: i18next.t("Attention"),
      message: i18next.t("If you delete the fund, <u><b>you'll lose all the connected datas.</b></u><br><b>Are you sure? This action can't be undone.</b>"),
      callback: function(result){
        if (result) {
          window.CRM.APIRequest({
            method: 'POST',
            path: 'donationfunds/delete',
            data: JSON.stringify({"fundId": fundId})
          }).done(function(data) {
            window.CRM.dataFundTable.ajax.reload();
          });
        }
      }
    });
  });  
  
  $(document).on("click",".edit-fund", function(){
     var fundId = $(this).data("id");
     
      window.CRM.APIRequest({
        method: 'POST',
        path: 'donationfunds/edit',
        data: JSON.stringify({"fundId": fundId})
      }).done(function(data) {
        var modal = bootbox.dialog({
         message: BootboxContentFundList,
         title: i18next.t("Fund Editor"),
         buttons: [
          {
           label: i18next.t("Save"),
           className: "btn btn-primary pull-left",
           callback: function() {
             var Activ = $("#activCheckbox").is(":checked");
             var Name = $("#Name").val();
             var Description = $("#description").val();
           
             window.CRM.APIRequest({
                method: 'POST',
                path: 'donationfunds/set',
                data: JSON.stringify({"fundId": fundId,"Activ":Activ, "Name": Name,"Description": Description})
             }).done(function(data) {
                window.CRM.dataFundTable.ajax.reload();
             });
            }
          },
          {
           label: i18next.t("Close"),
           className: "btn btn-default pull-left",
           callback: function() {
              console.log("just do something on close");
           }
          }
         ],
         show: false,
         onEscape: function() {
            modal.modal("hide");
         }
       });
       
       $("#activCheckbox").prop('checked', data.Active);
       $("#Name").val(data.Name);
       $("#description").val(data.Description);
  
       modal.modal("show");
      });
  });
  
  $(document).on("click","#add-new-fund", function(){
    var modal = bootbox.dialog({
     message: BootboxContentFundList,
     title: i18next.t("Add Fund"),
     buttons: [
      {
       label: i18next.t("Save"),
       className: "btn btn-primary pull-left",
       callback: function() {
         var Activ = $("#activCheckbox").is(":checked");
         var Name = $("#Name").val();
         var Description = $("#description").val();
       
         window.CRM.APIRequest({
            method: 'POST',
            path: 'donationfunds/create',
            data: JSON.stringify({"Activ":Activ, "Name": Name,"Description": Description})
         }).done(function(data) {
            window.CRM.dataFundTable.ajax.reload();
         });
        }
      },
      {
       label: i18next.t("Close"),
       className: "btn btn-default pull-left",
       callback: function() {
          console.log("just do something on close");
       }
      }
     ],
     show: false,
     onEscape: function() {
        modal.modal("hide");
     }
   });
   
   modal.modal("show");
  });

});