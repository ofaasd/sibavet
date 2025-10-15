<?php
function tanggal($date = 1){
    if(substr($date, 0,9) != '00-00-000' || substr($date, 0,9) != '00/00/000' || substr($date, 0,9) != '' || substr($date, 0,9) != NULL ){
        date_default_timezone_set('Asia/Jakarta'); // your reference timezone here
    //    $date = date('Y-m-d', strtotime($date)); // ubah sesuai format penanggalan standart
        $date = date('Y-m-j', strtotime($date)); // ubah sesuai format penanggalan standart
        if($date != '1970-01-01' && $date != '1970-01-1'){
//            echo $date.'<br>';
            $bulan = array ('01'=>'Januari', // array bulan konversi
                    '02'=>'Februari',
                    '03'=>'Maret',
                    '04'=>'April',
                    '05'=>'Mei',
                    '06'=>'Juni',
                    '07'=>'Juli',
                    '08'=>'Agustus',
                    '09'=>'September',
                    '10'=>'Oktober',
                    '11'=>'November',
                    '12'=>'Desember'
            );
            $date = explode ('-',$date); // ubah string menjadi array dengan paramere '-'

            return @$date[2] . ' ' . @$bulan[$date[1]] . ' ' . @$date[0]; // hasil yang di kembalikan}
        }else{
            return '';
        }

    }else{
        return '';
    }
}

function viewSelectLab($lab=0, $id='', $selected='',$class = ''){
	if($lab==0){
        $data = App\Models\MasterData\SubSatuanKerja::select('id','sub_satuan_kerja','kode')->get();
    }else{
        $data = App\Models\MasterData\SubSatuanKerja::select('id','sub_satuan_kerja','kode')->where('jenis',$lab)->get();
    }
	$html = "<select id='$id' name='$id' class='select2 form-control $class'><option value=''>- Pilih Laboratorium -</option>";
    foreach($data as $key=>$dt){
        $sel = ($selected == $dt->id)?'selected':'';
        $html .= "<option value='$dt->id' $sel >$dt->sub_satuan_kerja | $dt->kode</option>";
    }
    
    $html .= "</select>";

    return $html;	
}

function viewSelectSNI($id='', $selected='',$class = ''){
    $data = App\Models\MasterData\SNI::select('id','kode_etiket','nama')->where('status',1)->get();
    $html = "<select id=\"".$id."\" name=\"".$id."\" class=\"select2 form-control ".$class."\"><option value=\"\">-</option>";
    foreach($data as $key=>$dt){
        $sel = ($selected == $dt->id)?'selected':'';
        $html .= "<option value=\"".$dt->id."\" ".$sel." >".$dt->kode_etiket."</option>";
        // $html .= "<option value='".$dt->id."' ".$sel." >".$dt->kode_etiket." | ".$dt->nama."</option>";
    }
    
    $html .= "</select>";

    return $html;   
}

function viewSelectCustomer($id='', $selected='',$class = ''){
	$data = App\Models\MasterData\Customer::select('id','nama_pelanggan')->get();
	$html = "<select id='$id' name='$id' class='select2 form-control $class'><option value=''>- Pilih Pengirim -</option>";
    foreach($data as $key=>$dt){
        $sel = ($selected == $dt->id)?'selected':'';
        $html .= "<option value='$dt->id' $sel >$dt->nama_pelanggan</option>";
    }
    
    $html .= "</select>";

    return $html;	
}

function viewSelectSpesies($lab=0, $id='', $selected='',$class = ''){
	$data = App\Models\MasterData\Spesies::select('id','nama_spesies')->where('lab',$lab)->get();
	$html = "<select id='$id' name='$id' class='select2 form-control $class'><option value=''>- Pilih -</option>";
    foreach($data as $key=>$dt){
        $sel = ($selected == $dt->id)?'selected':'';
        $html .= "<option value='$dt->id' $sel >$dt->nama_spesies</option>";
    }
    
    $html .= "</select>";

    return $html;	
}

function viewSelectJenisContoh($lab=0, $id='', $selected='',$class = ''){
    $data = App\Models\MasterData\JenisContoh::select('nama_sampel','id','kode')->where('lab', $lab)->get();
    $html = '<select id="'.$id.'" name="'.$id.'" class="select2 form-control $class"><option value="">- Pilih -</option>';
    foreach($data as $key=>$dt){
        $sel = ($selected == $dt->id)?'selected':'';
        $html .= '<option value="'.$dt->id.'" '.$sel.' >'.$dt->kode.' | '.$dt->nama_sampel.'</option>';
    }
    
    $html .= "</select>";

    return $html;   
}

function viewSelectSeksiLab($lab=0,$id='', $selected='',$class = ''){
    $data = App\Models\MasterData\SeksiLaboratorium::select('seksi_laboratorium','id','kode')->where('lab', $lab)->get();
    $html = '<select id="'.$id.'" name="'.$id.'" class="select2 form-control $class"><option value="">- Pilih -</option>';
    foreach($data as $key=>$dt){
        $sel = ($selected == $dt->id)?'selected':'';
        $html .= '<option value="'.$dt->id.'" '.$sel.' >'.$dt->kode.' | '.$dt->seksi_laboratorium.'</option>';
    }
    
    $html .= "</select>";

    return $html;   
}


function viewSelectPermintaanUji_2($lab=0, $id='', $selected='',$class = ''){
    $data = App\Models\MasterData\SeksiLaboratorium::select('seksi_laboratorium','id','kode')->get();
    // $data = App\Models\MasterData\SeksiLaboratorium::select('seksi_laboratorium','id','kode')->where('lab', $lab)->get();
    $html = '<select id="'.$id.'" name="'.$id.'" class="select2 form-control $class" multiple="multiple" placeholder="sadasda"><option value="">- Pilih -</option>';
    foreach($data as $key=>$dt){
        $sel = ($selected == $dt->id)?'selected':'';
        $html .= '<option value="'.$dt->id.'" '.$sel.' >'.$dt->kode.' | '.$dt->seksi_laboratorium.'</option>';
    }
    
    $html .= "</select>";

    return $html;   
}

function viewSelectPermintaanUji($lab=0, $id='', $selected='',$class = ''){
    //memilih kelurahan
    $data = App\Models\MasterData\SeksiLaboratorium::select('seksi_laboratorium','id','kode')->where('lab',$lab)->get();
    $arr = array();
    foreach($data as $d){
        $pengujian = App\Models\MasterData\JenisPengujian::select('id','seksi_laboratorium_id','jenis_pengujian')->where('seksi_laboratorium_id',$d->id)->get();
        foreach($pengujian as $uji){
            $arr['Seksi '.$d->seksi_laboratorium][$uji->id] = 'Uji '.$uji->jenis_pengujian;
        }
    }
    $html = '<select name="'.$id.'" id="'.$id.'" class="select2 '.$class.'" style="width:100%" multiple="multiple">';
    $selected_values = (array) $selected;
    foreach ($arr as $group => $options) {
        $html .= '<optgroup label="'.$group.'">';
        foreach ($options as $value => $label) {
            $is_selected = in_array($value, $selected_values) ? ' selected' : '';
            $html .= '<option value="'.$value.'"'.$is_selected.'>'.$label.'</option>';
        }
        $html .= '</optgroup>';
    }
    $html .= '</select>';
    return $html;
}

function viewSelectKota($id='', $selected='',$class = ''){
    //memilih kelurahan
    $data = App\Models\Indonesia\Kota::select('name','id')->get();
    $html = '<select id="'.$id.'" name="'.$id.'" class="select2 form-control $class" ><option value="">- Pilih -</option>';
    
    foreach($data as $key=>$dt){
        $sel = ($selected == $dt->id)?'selected':'';
        $html .= '<option value="'.$dt->id.'" '.$sel.' >'.$dt->name.'</option>';
    }
    
    $html .= "</select>";

    return $html;
}

function viewSelectTanggal($id='', $value='', $class = ''){
    return \Form::text($id, $value, ['class'=>'form-control datepicker'.$class]);
    return '<input type="text" name="'.$id.'" id="'.$id.'" value="'.$value.'" class="form-control datepicker'.$class.'">';
}

function sumContohSeksi($lab,$seksi)
{
    $lab = $lab->where('seksi_laboratorium_id',$seksi);
    $lab = $lab->pluck('labContoh')->flatten();
    $lab = $lab->pluck('pcontoh')->flatten();
    return $lab->sum('jumlah');
}

function sumContohUji($lab,$uji)
{
    $lab = $lab->where('pengujian_id',$uji);
    return $lab->sum('nol')+$lab->sum('rendah')+$lab->sum('tinggi')+$lab->sum('negatif')+$lab->sum('positif');
}

function sumUjian($lab,$uji)
{
    $lab = $lab->where('pengujian_id',$uji);
    $nol = $lab->sum('nol');
    $rendah = $lab->sum('rendah');
    $tinggi = $lab->sum('tinggi');
    $positif = $lab->sum('positif');
    $negatif = $lab->sum('negatif');
    return collect([$nol,$rendah,$tinggi,$negatif,$positif]);
}

function sumUjianTotal($lab)
{
    $nol = $lab->sum('nol');
    $rendah = $lab->sum('rendah');
    $tinggi = $lab->sum('tinggi');
    $positif = $lab->sum('positif');
    $negatif = $lab->sum('negatif');
    return [$nol+$rendah+$tinggi+$negatif+$positif, $negatif, $positif, $nol, $rendah, $tinggi];
}

function viewSelectPegawai($lab=0, $id='', $selected='',$class = ''){
    $data = App\Models\MasterData\Pegawai::select('id','name','nip')->get();
    $html = "<select id='".$id."' name='".$id."' class='select2 form-control ".$class."'><option value=''>- Pilih Pegawai -</option>";
    foreach($data as $key=>$dt){
        $sel = ($selected == $dt->id)?'selected':'';
        $html .= "<option value='".$dt->id."' ".$sel." >".$dt->nip." | ".$dt->name."</option>";
    }
    
    $html .= "</select>";

    return $html;   
}

function url_kan()
{
    return asset('packages/img/kan.png');
}

function viewSelectLaboratorium($id='', $selected='',$class = ''){
    $html = "<select id='".$id."' name='".$id."' class='select2 form-control ".$class."'>"
        ."<option value='0' ".($selected==0?"selected":"")." >-</option>"
        ."<option value='1' ".($selected==1?"selected":"")." >Keswan</option>"
        ."<option value='2' ".($selected==2?"selected":"")." >Pakan</option>"
        ."<option value='3' ".($selected==3?"selected":"")." >Kesmavet</option>"
        ."</select>";
    return $html;   
}

function getNamaLaboratorium($value='')
{
    switch ($value) {
        case 1:
            return "Keswan";
            break;
        case 2:
            return "Pakan";
            break;
        case 3:
            return "Kesmavet";
            break;
        
        default:
            return "-";
            break;
    }
}
function testing_helpers(){
	return "asdasdasd berhasil";
}