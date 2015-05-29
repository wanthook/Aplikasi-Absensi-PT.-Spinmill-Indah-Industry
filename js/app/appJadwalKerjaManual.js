/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

  
$(document).ready(function()
{
    
    $('#tblJadwalKerjaManual').tablesorter({
        headers: 
        { 
            3: {sorter: false} 
        }
    });
    
    $("#txtPeriode").datepicker( {
        format: "mm-yyyy",
        viewMode: "months", 
        minViewMode: "months"
    }).on('changeDate',function(e)
    {
        var val = $(this).val();
        $("#tblPlace").off();
        load_table(val);
    });
    
    $('#txtPinKerjaManual').select2(
    {
        placeholder: "PIN",
        minimumInputLength: 0,
        ajax: 
        {
            url: pathJ,
            dataType: 'json',         
            data: function (term, page) 
            {                
                return { q : term  }
            },
            results: function(data, page ) 
            {
                return { results: data }
            }
        },
        initSelection: function(element, callback) 
        {
            var id = $(element).val();
            
            if(id!="")
            {
                $.ajax( 
                {                    
                    url: pathJ,
                    dataType: 'json',
                    data: {id: id}
                }).done(function(data){ callback(data[0]); });
            }
        }
    });
    
    $('#cmbJadwal').select2(
    {
        placeholder: "Jam Kerja",
        minimumInputLength: 0,
        ajax: 
        {
            url: pathJ+"/sJadwal",
            dataType: 'json',         
            data: function (term, page) 
            {                
                return { q : term  }
            },
            results: function(data, page ) 
            {
                return { results: data }
            }
        },
        initSelection: function(element, callback) 
        {
            var id = $(element).val();
            
            if(id!="")
            {
                $.ajax( 
                {                    
                    url: pathJ+"/sJadwal",
                    dataType: 'json',
                    data: {id: id}
                }).done(function(data){ callback(data[0]); });
            }
        }
    });
    
    $("#cmdHapusJamKerja").click(function(e)
    {
        e.preventDefault();
        
        $("#cmbJadwal").select2('val','');
    });
    
    $('#txtPinKerjaManual').select2(
    {
        placeholder: "Karyawan",
        minimumInputLength: 0,
        ajax: 
        {
            url: pathJ+"/sKaryawan",
            dataType: 'json',         
            data: function (term, page) 
            {                
                return { q : term  }
            },
            results: function(data, page ) 
            {
                return { results: data }
            }
        },
        initSelection: function(element, callback) 
        {
            var q = $(element).val();

            if(q!="")
            {
                $.ajax( 
                {                    
                    url: pathJ+"/sKaryawan",
                    dataType: 'json',
                    data: {id: q}
                }).done(function(data){ callback(data[0]); });
            }
        }
    });
    
    load_table("");    
    
});

function load_table(date)
{
    if($("#tblPlace")!=null)
    {
        var id = $("#txtId").val();
        $("#tblPlace").load(pathJ+"/load_stable?date="+date+"&id="+id)
                      .delegate("#tblJadwalKerjaManualDate tr td", "click", function () {
                          var td = $(this);  
                          
                          var val = td.text();
//                            console.log(td.attr('dt'));
                            val = val.replace(/^\s+|\s+$/g, '');
                            
                            if(val!='')
                            {
//                              $("#coba").load(pathAddTblJad);
                                var periode = $("#txtPeriode").val();
                                var jadwal = $("#cmbJadwal").val();
//                                td.css({"background-color":"#777"});
                                if(jadwal!="")
                                {
                                    //jika table sudah pernah ternodai wkwkwkwkwk
                                    if(val.length > 2)
                                    {
                                        var exp = val.split("\n");
                                        val = exp[0];
                                    }
                                  
                                    $.ajax({
                                        url: pathJ+"/add_stable_temp",
                                        dataType: 'json',
                                        type: 'POST',
                                        data: {per:periode, jad:jadwal, tgl:td.attr('dt')}
                                    }).done(function(data) {
                                        td.html(val+"\n<br>"+data.kode+"\n<br>"+data.jam);
                                        td.css({"background-color":data.warna});
                                    });
                                }
                                //delete detail
                                else
                                {
                                    if(val.length > 2)
                                    {
                                        var exp = val.split("\n");
                                        val = exp[0];
                                    
                                        $.ajax({
                                            url: pathJ+"/delete_stable_temp",
                                            dataType: 'json',
                                            type: 'POST',
                                            data: {per:periode,  tgl:td.attr('dt')}
                                        }).done(function(data) {
                                            td.html(val);
                                            td.css({"background-color":""});
                                        });
                                    }
                                }
                            }
                      });
    }
}

//function load_table(date)
//{
//    if($("#tblPlace")!=null)
//    {
//        var id = $("#txtId").val();
//        $("#tblPlace").load(pathTblJad+"?date="+date+"&id="+id)
//                      .delegate("#tblJadwalKerjaManualDate tr td", "click", function () {
//                          var td = $(this);  
//                          
//                          var val = td.text();
////                            console.log(td.attr('dt'));
//                            val = val.replace(/^\s+|\s+$/g, '');
//                            
//                            if(val!='')
//                            {
////                              $("#coba").load(pathAddTblJad);
//                                var periode = $("#txtPeriode").val();
//                                var jadwal = $("#cmbJadwal").val();
////                                td.css({"background-color":"#777"});
//                                if(jadwal!="")
//                                {
//                                    //jika table sudah pernah ternodai wkwkwkwkwk
//                                    if(val.length > 2)
//                                    {
//                                        var exp = val.split("\n");
//                                        val = exp[0];
//                                    }
//                                  
//                                    $.ajax({
//                                        url: pathAddTblJad,
//                                        dataType: 'json',
//                                        type: 'POST',
//                                        data: {per:periode, jad:jadwal, tgl:val}
//                                    }).done(function(data) {
//                                        td.html(val+"\n<br>"+data.kode+"\n<br>"+data.jam);
//                                        td.css({"background-color":data.warna});
//                                    });
//                                }
//                                //delete detail
//                                else
//                                {
//                                    if(val.length > 2)
//                                    {
//                                        var exp = val.split("\n");
//                                        val = exp[0];
//                                    
//                                        $.ajax({
//                                            url: pathDelTblJad,
//                                            dataType: 'json',
//                                            type: 'POST',
//                                            data: {per:periode,  tgl:val}
//                                        }).done(function(data) {
//                                            td.html(val);
//                                            td.css({"background-color":""});
//                                        });
//                                    }
//                                }
//                            }
//                      });
//    }
//}