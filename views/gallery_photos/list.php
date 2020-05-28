<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                <h4>List of Gallery Photos
                    <a href="<?php echo URL::abs('gallery_photos/add'); ?>" class="btn btn-send pull-right">
                        <i class="fa fa-plus"></i> Add
                    </a>
                </h4>
            </header>
            <div class="panel-body">



                <?php
                /* @var $paginator Paginator */
                if (isset($paginator)) {
                    $paginator->display();
                }
                ?>

                <table class="table table-striped table-advance table-hover">

                    <thead>
                        <tr id="title-line">
                            <th>id</th>
                            <th>image</th>
                            <th>title</th>
                            <th>comment</th>
                            <th>created_at</th>

                            <th> Action </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($gallery_photos as $key => $gallery_photo): /* @var $gallery_photo GalleryPhoto */ ?>
                            <tr>
                                <td><?php echo $gallery_photo->id; ?></td>
                                <td>
                                    <img style="max-width: 200px;" src="<?php  
                                    $img = new Image($gallery_photo->image);
                                    echo $img->thumbnail()->url; ?>" alt="" /> 
                                </td>
                                <td><?php echo $gallery_photo->title; ?></td>
                                <td><?php echo $gallery_photo->comment; ?></td>
                                <td><?php echo $gallery_photo->created_at; ?></td>

                                <td> 
                                    <a href="<?php echo URL::abs('gallery_photos/edit/' . $gallery_photo->id); ?>" class="btn btn-success btn-xs">
                                        edit
                                    </a>
                                    <a onclick="return confirm('Are you sure?');" href="<?php echo URL::abs('gallery_photos/delete/' . $gallery_photo->id); ?>" class="btn btn-danger btn-xs">
                                        delete
                                    </a>
                                </td>
                            </tr>   
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</div>
