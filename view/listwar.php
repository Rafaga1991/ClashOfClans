<script>
    var idElementName = [];

    function setElement(id) {
        idElementName.push(id);
    }
</script>

<div class="container-fluid mt-7">
    <div class="card">
        <div class="card-header">
            Lista de los Miembros en Guerras
        </div>
        <div class="card-body">
            <table class="table" id="listMembersWars">
                <caption>
                    <?php if (Session::Admin() || Session::isPrivilegedInClan() || Session::superAdmin()) : ?>
                        <span data-toggle="tooltip" title="Nueva Lista de Guerra">
                            <a href="#" class="btn btn-sm btn-default" data-toggle="modal" data-target="#newList">Crear</a>
                        </span>
                    <?php endif; ?>
                </caption>
                <thead>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="lists">
                    <?php foreach ($listMembersWar as $key => $data) : ?>
                        <tr>
                            <td>
                                <a href="<?= $request['get']['listMember'] ?>?id=<?= $data['id'] ?>" target="_blank" data-toggle="tooltip" title="Lista de Guerra">
                                    <i class="fas fa-list"></i> <?= $data['date'] ?> | <?= $data['cantMember'] ?> vs <?= $data['cantMember'] ?>
                                </a>
                            </td>
                            <td>
                                <?php
                                $members = '';
                                foreach ($data['members'] as $index => $member) {
                                    $members .= ($index + 1) . ". {$member['name']}, ";
                                }
                                $members = substr($members, 0, strlen($members) - 2) . '.';
                                $result = explode(',', $members);
                                $members = '';
                                foreach($result as $index => $dat){
                                    if($index == count($result)-1){
                                        $members .= " y$dat";
                                    }elseif($index == count($result)-2){
                                        $members .= $dat;
                                    }else{
                                        $members .= "$dat,";
                                    }
                                }

                                ?>
                                <input type="text" class="form-control" value="Lista de Guerra: <?= $members ?>">
                            </td>
                            <td>
                                <?php if (Session::Admin() || Session::isPrivilegedInClan() || Session::superAdmin()) : ?>
                                    <a href="<?= $request['get']['delete'] ?>?view=<?= $view ?>&id=<?= $data['id'] ?>">Eliminar</a> |
                                    <a href="#" data-toggle="modal" data-target="#updateList<?= $key ?>" idList="<?= $data['id'] ?>" onclick="onClickUpdate(this, 'cantMemberUpdate<?= $key ?>')">Actualizar</a>
                                    <div class="modal fade" id="updateList<?= $key ?>" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
                                        <div class="modal-dialog modal- modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h6 class="modal-title"><img src="<?= $info['badgeUrls']['small'] ?>" alt=""> Nueva lista de Guerra</h6>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>

                                                <div class="modal-body">
                                                    <div class="text-left">Seleccionados: <span id="cantMemberUpdate<?= $key ?>"></span></div>
                                                    <table class="text-left table" id="updateListMembers<?= $key ?>">
                                                        <thead>
                                                            <tr>
                                                                <th>Miembros</th>
                                                                <th>Copas</th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach ($info['memberList'] as $index => $member) : ?>
                                                                <tr>
                                                                    <td>
                                                                        <img src="<?= $member['league']['iconUrls']['small'] ?>" width="40px" alt=""><?= $member['name'] ?>
                                                                    </td>
                                                                    <td>
                                                                        <?= $member['trophies'] ?></td>
                                                                    <td>
                                                                        <input type="checkbox" onclick="selected(this, 'cantMemberUpdate<?= $key ?>')" position="<?= $index ?>" trophies="<?= $member['trophies'] ?>" url="<?= $member['league']['iconUrls']['small'] ?>" member="<?= $member['name'] ?>" <?= (inArray($member['name'], $data['members'], 'name') ? 'checked' : '') ?>>
                                                                    </td>
                                                                </tr>
                                                            <?php endforeach; ?>
                                                        </tbody>
                                                    </table>
                                                    <script>
                                                        setElement('updateListMembers<?= $key ?>');
                                                    </script>
                                                    <hr class="my-4" />
                                                    <!-- Description -->
                                                    <h6 class="heading-small text-muted mb-4">Descripci&oacute;n</h6>
                                                    <div class="pl-lg-4">
                                                        <div class="form-group">
                                                            <label class="form-control-label">Descripci&oacute;n</label>
                                                            <textarea rows="4" id="txtDescriptionListUpdate<?= $key ?>" class="form-control" placeholder="(opcional)"><?= $data['description'] ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" onclick="sendUpdateMembers('<?= $data['id'] ?>', '<?= $key ?>')" class="btn btn-primary" data-dismiss="modal">Actualizar</button>
                                                    <button type="button" class="btn btn-link  ml-auto" data-dismiss="modal">Cerrar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php if (Session::Admin() || Session::isPrivilegedInClan() || Session::superAdmin()) : ?>
    <div class="modal fade" id="newList" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
        <div class="modal-dialog modal- modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="modal-title-default"><img src="<?= $info['badgeUrls']['small'] ?>" alt=""> Nueva lista de Guerra</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="text-left">Seleccionados: <span id="cantMember"></span></div>
                    <table class="text-left" id="listMembers">
                        <thead>
                            <tr>
                                <th>Miembros</th>
                                <th>Copas</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($info['memberList'] as $key => $member) : ?>
                                <tr>
                                    <td><img src="<?= $member['league']['iconUrls']['small'] ?>" width="40px" alt=""><?= $member['name'] ?></td>
                                    <td><?= $member['trophies'] ?></td>
                                    <td><input type="checkbox" onclick="selected(this, 'cantMember')" position="<?= $key ?>" trophies="<?= $member['trophies'] ?>" url="<?= $member['league']['iconUrls']['small'] ?>" member="<?= $member['name'] ?>"></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <hr class="my-4" />
                    <!-- Description -->
                    <h6 class="heading-small text-muted mb-4">Descripci&oacute;n</h6>
                    <div class="pl-lg-4">
                        <div class="form-group">
                            <label class="form-control-label">Descripci&oacute;n</label>
                            <textarea rows="4" id="txtDescriptionList" class="form-control" placeholder="(opcional)"></textarea>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" onclick="sendMembers()" class="btn btn-primary" data-dismiss="modal">Crear</button>
                    <button type="button" class="btn btn-link  ml-auto" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<script>
    function onClickUpdate(element, idelement) {
        elementID = idelement;
        $.post(
            '<?= $request['post']['listwar'] ?>', {
                LIST_ACTION: "get",
                LIST_ID: $(element).attr('idList')
            }, (val) => {
                val = JSON.parse(val);
                values = val.members;
                cantElementSelect[idelement] = values.length;
                $('#' + idelement)[0].innerHTML = cantElementSelect[idelement];
            }
        )
    }

    function sendUpdateMembers(id, position) {
        $.post(
            '<?= $request['post']['listwar'] ?>', {
                LIST_ID: id,
                LIST: {
                    id: id,
                    members: values,
                    description: $('#txtDescriptionListUpdate' + position).val()
                },
                LIST_ACTION: "update"
            }, (value) => {
                Swal.fire(
                    'Actualizada!',
                    'Lista de Guerra Actualizada.',
                    'success'
                ).then(() => {
                    location.reload();
                })

            }
        )
    }
</script>