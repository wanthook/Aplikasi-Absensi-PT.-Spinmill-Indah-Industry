/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function()
{
    $('#tblJamKerja').tablesorter({
        headers: 
        { 
            6: {sorter: false} 
        }
    });
    $('#txtJamMasuk,#txtJamPulang').mask('00:00:00');
    $('[name="txtWarna"]').colorpicker();
});

