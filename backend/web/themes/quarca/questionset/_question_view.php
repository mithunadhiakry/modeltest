<?php

use yii\helpers\Html;
use yii\widgets\DetailView;


?>
<div class="question-view pane">

    
    <div class="details">
        <?= $model->details; ?>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Answer</th>
                <th>Is Correct</th>
            </tr>
        </thead>
        <tbody>
            <?php
                if(!empty($answer_list)){
                    $i=0;
                    foreach ($answer_list as $key => $value) {
                        $i++;
                        echo '<tr>';
                            echo '<td>'.$i.'</td>';
                            echo '<td>'.$value->answer.'</td>';
                            echo '<td>'.(($value->is_correct == 1)?'Yes':'No').'</td>';
                        echo '</tr>';
                    }
                }
            ?>
        </tbody>
    </table>
    

</div>
