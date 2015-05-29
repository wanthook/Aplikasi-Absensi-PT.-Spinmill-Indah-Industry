/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
  
var statusKar = [
    {'id':'A', 'text':'Aktif'},
    {'id':'N', 'text':'Tidak Aktif'}
];

var statusKontrak = [
    {'id':'Y', 'text':'Kontrak'},
    {'id':'N', 'text':'Tidak Kontrak'}
];

var jenisKelamin = [
    {'id':'L', 'text':'Laki-laki'},
    {'id':'P', 'text':'Perempuan'}
];
  
var statusMarital = [
    {'id':'L', 'text':'Lajang'},
    {'id':'K', 'text':'Kawin'}
];

var statusRumah = [
    {'id':1, 'text':'Milik Sendiri'},
    {'id':2, 'text':'Ikut Orang Tua'},
    {'id':3, 'text':'Kontrak'},
    {'id':4, 'text':'Mess Karyawan'}
];
  
$(document).ready(function()
{
    
    $('#tblKaryawan').tablesorter({
        headers: 
        { 
            7: {sorter: false} 
        }
    });
    
    $('#cmbJabatan').select2(
    {
        placeholder: "Pilih Jabatan",
        minimumInputLength: 0,
        ajax: 
        {
            url: pathJabatan,
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
                    url: pathJabatan,
                    dataType: 'json',
                    data: {id: id}
                }).done(function(data){ callback(data[0]); });
            }
        }
    });
    
    $('#cmbDivisi').select2(
    {
        placeholder: "Pilih Divisi",
        minimumInputLength: 0,
        ajax: 
        {
            url: pathDivisi,
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
                    url: pathDivisi,
                    dataType: 'json',
                    data: {id: id}
                }).done(function(data){ callback(data[0]); });
            }
        }
    });
    
    $('#cmbStatus').select2(
    {
        placeholder: "Status Karyawan",
        minimumInputLength: 0,
        data:{results : statusKar}
    });
    
    $('#txtTglMasuk').datepicker({format:'dd-mm-yyyy'});
    
    $('#txtTglNpwp').datepicker({});
    
    $('#cmbStatusKontrak').select2(
    {
        placeholder: "Status Kontrak",
        minimumInputLength: 0,
        data:{results : statusKontrak}
    });
    
    $('#txtTglAwalKontrak').datepicker({format:'dd-mm-yyyy'});
    
    $('#txtTglAkhirKontrak').datepicker({format:'dd-mm-yyyy'});
    
    $('#cmbJenisKelamin').select2(
    {
        placeholder: "Jenis Kelamin",
        minimumInputLength: 0,
        data:{results : jenisKelamin}
    });
    
    $('#txtTglLahir').datepicker({startView: 2,format:'dd-mm-yyyy'});
    
    $('#cmbPendidikan').select2(
    {
        placeholder: "Pilih Pendidikan",
        minimumInputLength: 0,
        ajax: 
        {
            url: pathPendidikan,
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
                    url: pathPendidikan,
                    dataType: 'json',
                    data: {id: id}
                }).done(function(data){ callback(data[0]); });
            }
        }
    });
    
    $('#txtTahunLulus').mask('0000');
    
    $('#cmbAgama').select2(
    {
        placeholder: "Pilih Agama",
        minimumInputLength: 0,
        ajax: 
        {
            url: pathAgama,
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
                    url: pathAgama,
                    dataType: 'json',
                    data: {id: id}
                }).done(function(data){ callback(data[0]); });
            }
        }
    });
    
    $('#txtTlp').mask('000000000000000');
    
    $('#txtKtp').mask('0000000000000000');
    
    $('#txtTglKtp').datepicker({format:'dd-mm-yyyy'});
    
    $('#cmbStatusMarital').select2(
    {
        placeholder: "Status Marital",
        minimumInputLength: 0,
        data:{results : statusMarital}
    });
    
    $('#cmbStatusRumah').select2(
    {
        placeholder: "Status Rumah",
        minimumInputLength: 0,
        data:{results : statusRumah}
    });
    
    $('#txtKodePos').mask('00000');
    
    $('#txtKodePosKtp').mask('00000');
    
    $('#txtTlpSaudara').mask('000000000000000');
    
    $('#txtTglLahirIstri').datepicker({format:'dd-mm-yyyy'});
    
    $('#txtTglLahirAnak1').datepicker({format:'dd-mm-yyyy'});
    
    $('#txtTglLahirAnak2').datepicker({format:'dd-mm-yyyy'});
    
    $('#txtTglLahirAnak3').datepicker({format:'dd-mm-yyyy'});
});