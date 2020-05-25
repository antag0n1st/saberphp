<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                <h4>List of Student
                    <a href="<?php echo URL::abs('students/add'); ?>" class="btn btn-send pull-right">
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
			<th>counter</th>
			<th>name</th>
			<th>email</th>
			<th>created_at</th>

                            <th> Action </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($students as $key => $student): /* @var $student Student */ ?>
                            <tr>
                                				<td><?php echo $student->id; ?></td>
				<td><?php echo $student->counter; ?></td>
				<td><?php echo $student->name; ?></td>
				<td><?php echo $student->email; ?></td>
				<td><?php echo $student->created_at; ?></td>

                                <td> 
                                    <a href="<?php echo URL::abs('students/edit/' . $student->id); ?>" class="btn btn-success btn-xs">
                                       edit
                                    </a>
                                    <a onclick="return confirm('Are you sure?');" href="<?php echo URL::abs('students/delete/' . $student->id); ?>" class="btn btn-danger btn-xs">
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
