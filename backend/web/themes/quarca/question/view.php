<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use backend\models\Question;

/* @var $this yii\web\View */
/* @var $model backend\models\Question */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Questions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="question-view pane">

    <p>
        <?= Html::a('Edit', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?php
            $subject_id = $model->subject_id;

            $next = Question::find()->where(['subject_id' => $subject_id])->andWhere(['>', 'id', $model->id])->one();

            if(!empty($next)){
               $next_question_id = $next->id;
            }else{
                $prev = Question::find()->where(['subject_id' => $subject_id])->orderBy('id asc')->one();
                $next_question_id = $prev->id;
            }

           

        ?>

        <a href="<?= Url::toRoute(['question/view?id='.$next_question_id]) ?>" class="btn btn-primary">View & next</a>
    </p>
    <div class="details">
        <strong><?= $model->category->category_name; ?> /  <?= $model->subcategory->category_name; ?> / <?= $model->subject->subject_name; ?> / <?=  $model->chapter->chaper_name ?></strong>
    </div>
    <div class="details">
        <?= $model->details; ?>
    </div>
    <p>&nbsp;</p>

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
