<thead>
    <tr>
        <th>Gambar</th>
        <th>Title</th>
        <th>Status</th>
        <th>Promo</th>
        <th>Option</th>
    </tr>
</thead>
<tbody>
  <?php
  if(is_array($data)){
    $status = array(
      2 => "<span class='label label-default'>Draft</span>",
      1 => "<span class='label label-success'>Active</span>",
    );
    $promo = array(
      2 => "<span class='label label-success'>Promo</span>",
      1 => "<span class='label label-info'>Available</span>",
      NULL => "<span class='label label-info'>Available</span>",
    );
    foreach ($data as $key => $value) {
      
      if($value->file_temp)
        $gambar = base_url()."files/antavaya/haji/{$value->file_temp}";
      else
        $gambar = base_url()."files/no-pic.png";
      
      print '
      <tr>
        <td><img src="'.$gambar.'" width="150"></td>
        <td>'.$value->title.' <br /> '.$value->sub_title.'</td>
        <td>'.$status[$value->status].'</td>
        <td>'.$promo[$value->promo].'</td>
        <td>
          <div class="btn-group">
            <button data-toggle="dropdown" class="btn btn-small dropdown-toggle">Action<span class="caret"></span></button>
            <ul class="dropdown-menu">
              <li><a href="'.site_url("haji/master-haji/add-new-haji/".$value->id_website_haji).'">Edit</a></li>
              <li><a href="'.site_url("haji/master-haji/delete-haji/".$value->id_website_haji).'">Delete</a></li>
            </ul>
          </div>
        </td>
      </tr>';
    }
  }
  ?>
</tbody>