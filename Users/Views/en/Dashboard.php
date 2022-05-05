<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://bootswatch.com/5/lux/bootstrap.min.css" rel="stylesheet">
    <title> Dashboard </title>
</head>
<body>
<?php require_once $_SERVER['DOCUMENT_ROOT']."/assets/html/nav bar.php"; ?>
    
<div class="row mt-5">
    <div class="col-md-7 m-auto">
            <?php 
            global $companies;
            foreach ( $companies as $company ) {  ?>
                
                    <div class="card text-white bg-primary mb-3"  id="input_div" >
                        
                        <div class="card-header"><?php echo $company["Company_Name"]; ?> storages : </div>
                            <div class="card-body">
                            <table class="table table-dark">
                                <thead>
                                    <tr>
                                        <th scope="col">Storage Id</th>
                                        <th scope="col">Manage Storage</th>
                                        <!-- <th scope="col">Storage Archive</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                
                                    <?php foreach ( $company["Storages"] as $storage ) { 
                                        if( $storage["Item_Edit"] != 0 || $storage["Item_Enter"] != 0 || $storage["Item_Exit"] != 0 ){ 
                                    ?>
                                            <tr >
                                                <th scope="col"><?php echo $storage["Storage_Id"]; ?></th>
                                                <td>
                                                    <button class="btn btn-danger"  id = "manage_button" storage_id = "<?php echo $storage["Storage_Id"]; ?>" > Open Storage </button>
                                                </td>
                                                <!-- <?php //if( $storage["Item_Edit"] ) {?>
                                                    <td>
                                                        <button class="btn btn-info"  id = "archive_button" storage_id = "<?php echo $storage["Storage_Id"]; ?>" > Open Archive </button>
                                                    </td>
                                                <?php //} ?> -->
                                            </tr>
                                    <?php }} ?>
                                
                                </tbody>
                            </table>
                            </div>

                    </div>

            <?php } ?>
    </div>
</div>



    <script>

        var Manage_buttons = document.querySelectorAll("#manage_button")
        var Archive_buttons = document.querySelectorAll("#archive_button")


        function manage_items( id ){
            window.location.assign( window.location.origin + "/Users/Manage%20Items.php?page=0&storage_id="+id )
        }

        function archive( id ){
            window.location.assign( window.location.origin + "/Users/Items Archive.php?page=0&storage_id="+id )
        }


        Manage_buttons.forEach( ( button ) =>{

            button.onmousedown = () =>{

                manage_items( button.getAttribute("storage_id") )

            }
        })

        Archive_buttons.forEach( ( button ) =>{

            button.onmousedown = () =>{

                archive( button.getAttribute("storage_id") )

            }
        })
    </script>



</body>
</html>
