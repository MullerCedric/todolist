<header class="wrapper grid">
    <div id="branding" class=""><a href="index.php">Todolist</a></div>
    <div class="ta-right"><a href="index.php?r=auth&a=getLogout">Déconnexion</a></div>
</header>

<div class="main-content wrapper">
    <h1>Vos prochaines tâches</h1>
    <?php if ($data['tasks']): ?>
        <ol class="tasks">
            <?php foreach ($data['tasks'] as $task): ?>
                <li>
                    <div class="task grid">
                        <div class="column--heavy">
                            <form action="index.php"
                                  method="post">
                                <label for="<?= $task->taskID; ?>"
                                       class="checkbox ">
                                    <input title="Changer le statut"
                                           type="checkbox"
                                           id="<?= $task->taskID; ?>"
                                           name="is_done"
                                           <?php if( $task->is_done == 1 ){ echo 'checked'; } ?>
                                    >
                                    <span class="checkbox__label fs-base" <?php if( $task->is_done == 1 ){ echo 'style="text-decoration: line-through"'; } ?>><?= $task->description; ?></span>
                                </label>
                                <?php if( $task->editable ):?>
                                    <label for="description"
                                           class="textfield">
                                        <input type="text"
                                               size="40"
                                               value="<?= $task->description; ?>"
                                               name="description"
                                               title="description"
                                               id="description">
                                        <span class="textfield__label">Description</span>
                                    </label>
                                <?php endif; ?>
                                <input type="hidden"
                                       name="r"
                                       value="task">
                                <input type="hidden"
                                       name="a"
                                       value="postUpdate">
                                <input type="hidden"
                                       name="id"
                                       value="<?= $task->taskID; ?>">
                                <button type="submit">Enregistrer</button>
                            </form>
                        </div>
                        <div>
                            <form action="index.php"
                                  method="get">
                                <input type="hidden"
                                       name="a"
                                       value="getUpdate">
                                <input type="hidden"
                                       name="r"
                                       value="task">
                                <input type="hidden"
                                       name="id"
                                       value="<?= $task->taskID; ?>">
                                <button type="submit">Modifier</button>
                            </form>
                        </div>
                        <div>
                            <form action="index.php"
                                  method="post">
                                <button type="submit">Supprimer</button>
                                <input type="hidden"
                                       name="a"
                                       value="delete">
                                <input type="hidden"
                                       name="r"
                                       value="task">
                                <input type="hidden"
                                       name="id"
                                       value="<?= $task->taskID; ?>">
                            </form>
                        </div>
                    </div>
                </li>
            <?php endforeach; ?>
        </ol>
    <?php else: ?>
        <p>Vous n’avez pas encore créé de tâche…</p>
    <?php endif; ?>

    <hr>

    <h1>Ajouter une tâche</h1>
    <form action="index.php"
          method="post">
        <label for="description"
               class="textfield"><input type="text"
                                        name="description"
                                        id="description"
                                        size="80">
            <span class="textfield__label">Description</span>
        </label>
        <input type="hidden"
               name="r"
               value="task">
        <input type="hidden"
               name="a"
               value="create">
        <button type="submit">Créer cette nouvelle tâche</button>
    </form>
</div>