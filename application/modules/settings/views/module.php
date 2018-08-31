<thead>
    <tr>
        <th>Module</th>
        <th>Code</th>
        <th>Status</th>
        <th>Update</th>
        <th>Option</th>
      </tr>
    </thead>
    <tbody>
      <?php
      if(is_array($data)){
        foreach ($data as $key => $value) {
          $link_detail = site_url("settings/add-new-module/".$value->id_module);
          $link_delete = site_url("settings/delete-module/".$value->id_module);
          if($value->status == 1)
            $status = '<span class="label label-warning">Draft</span>';
          else
            $status = '<span class="label label-success">Active</span>';
          print "
      <tr>
        <td><a href='".site_url("settings/control/{$value->id_module}")."'>{$value->desc}</a></td>
        <td>{$value->name}</td>
        <td>{$status}</td>
        <td>{$value->versi}</td>
        <td>
          <div class='btn-group'>
            <button data-toggle='dropdown' class='btn btn-small dropdown-toggle'>Action<span class='caret'></span></button>
            <ul class='dropdown-menu'>
              <li><a href='{$link_detail}'>Edit</a></li>
              <li><a href='{$link_delete}'>Delete</a></li>
              <li><a href='".site_url("settings/get-controller/{$value->id_module}")."'>Get Controllers</a></li>
              <li><a href='".site_url("{$value->name}/update")."'>Update</a></li>
            </ul>
          </div>
        </td>
      </tr>";
        }
      }
      ?>
</tbody>