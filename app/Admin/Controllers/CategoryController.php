<?php

namespace App\Admin\Controllers;

use App\Models\Category;
use App\Models\MajorCategory;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class CategoryController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Category';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
        // gridメソッド：データの一覧表示を簡単に作成できるLaravel-Adminパッケージの一部です。データベースのデータをグリッド形式で表示する機能。
    protected function grid()
    {
        // gridメソッドは、Laravel-AdminのGridクラスのインスタンスに対して使用
        $grid = new Grid(new Category()); //CategoryモデルのインスタンスをGridに設定
        // $gridからcolumnメソッドを使用、第１引数：出力したいテーブルのカラム名を指定、第２引数：ラベル名
        $grid->column('id', __('Id'))->sortable();
        $grid->column('name', __('Name'));
        $grid->column('description', __('Description'));
        $grid->column('major_category_id', __('Major category name'))->editable('select', MajorCategory::all()->pluck('name', 'id'));
        $grid->column('created_at', __('Created at'))->sortable();
        $grid->column('updated_at', __('Updated at'))->sortable();

        $grid->filter(function($filter){
            // 部分一致のフィルタを追加する関数。第1引数にカラム名、第2引数に画面に表示する文字列を指定
            $filter->like('name', 'カテゴリー名');
            $filter->like('major_category_name', '親カテゴリー名')->multipleSelect(MajorCategory::all()->pluck('name', 'id'));
            // 範囲指定のフィルタを追加する関数です。datetime()を付与することで、カレンダーを表示して指定できる
            $filter->between('created_at', '登録日')->datetime();
        });

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Category::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('description', __('Description'));
        $show->field('major_category_id', __('Major category name'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form() //新規登録・編集機能
    {
        $form = new Form(new Category());

        $form->text('name', __('Name'));
        $form->textarea('description', __('Description'));
        $form->text('major_category_id', __('Major category Name'));

        return $form;
    }
}
