<thead>
    <tr>
        <th>Sort</th>
        <th>Pic</th>
        <th>Title</th>
        <th>Mulai</th>
        <th>Akhir</th>
        <th>Status</th>
        <th>Option</th>
    </tr>
</thead>
<tbody>
  <?php
  if(is_array($data)){
    $status = array(
      1 => "<span class='label label-info'>Reguler</span>",
      2 => "<span class='label label-success'>Selalu Ada</span>",
      3 => "<span class='label label-warning'>Cadangan</span>",
      4 => "<span class='label label-default'>Draft</span>",
    );
    foreach ($data as $key => $value) {
      if($value->file)
        $gambar = base_url()."files/umroh/slide2/{$value->file}";
      else
        $gambar = base_url()."files/no-pic.png";
      
      print '
      <tr>
        <td>'.$value->sort.'</td>
        <td><img src="'.$gambar.'" width="100"></td>
        <td>'.$value->title.'</td>
        <td>'.$value->mulai.'</td>
        <td>'.$value->akhir.'</td>
        <td>'.$status[$value->status].'</td>
        <td>
          <div class="btn-group">
            <button data-toggle="dropdown" class="btn btn-small dropdown-toggle">Action<span class="caret"></span></button>
            <ul class="dropdown-menu">
              <li><a href="'.site_url("front/add-banner-promosi/{$value->id_front_banner_promosi}").'">Edit</a></li>
            </ul>
          </div>
        </td>
      </tr>';
    }
  }
  ?>
</tbody>