<!--
AVISO
1 - Por el momento cada categoria, menu, submenu se agrega en la tabla menu hasta que se diseñe CRUD del menu.
2 - La misma tiene que estar asociada al rol para que tenga acceso.
-->

      <aside class="main-sidebar">
        <section class="sidebar">
          <ul class="sidebar-menu">
            <li>
              <a href="http://ssti.cecaitra.com/" target="_blank"><i class="fa fa-home text-primary"></i> <span>Ingresar al SSTI</span></a>
            </li>

            <form action="<?= base_url("detalle_protocolo");?>" method="POST" class="sidebar-form">
              <div class="input-group">
                <input type="text" name="protocolo" class="form-control" placeholder="Buscar Protocolo" maxlength="6" autocomplete="off">
                    <span class="input-group-btn">
                      <button type="submit" name="search"  class="btn btn-flat"><i class="fa fa-search"></i>
                      </button>
                    </span>
              </div>
            </form>

            <?php foreach ($categorias as $categoria): ?>
              <li class="header"><?= $categoria->nombre?></li> <!-- Imprimo las categorias-->
                <?php foreach ($menus as $menu): ?>
                  <?php if ($categoria->id == $menu->padre ): ?>
                    <li class="treeview">
                        <a href="<?= base_url($menu->link)?>">
                            <i class="<?= $menu->icono?>"></i>
                            <span><?= $menu->nombre?></span> <!-- Imprimo las menu-->
                            <?php if ($menu->link == '#'): ?> <!-- Si hay submenus imprime el icono-->
                              <i class="fa fa-angle-left pull-right"></i>
                            <?php endif; ?>
                        </a>
                        <?php if ($menu->link == '#'): ?>
                        <?php foreach ($submenus as $submenu): ?>
                          <?php if ($menu->id == $submenu->padre): ?>
                            <ul class="treeview-menu">
                              <li><a href="<?= base_url($submenu->link); ?>" style="margin-left: 10px;"><i class="fa fa-angle-double-right"></i> <?= $submenu->nombre?></a></li> <!-- Imprimo los submenu-->
                            </ul>
                          <?php endif; ?>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </li>
                <?php endif; ?>
              <?php endforeach; ?>
            <?php endforeach; ?>
          </ul>
        </section>
      </aside>
