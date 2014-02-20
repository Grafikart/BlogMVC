class CreatePosts < ActiveRecord::Migration
  def change
    create_table :posts do |t|
      t.references :category, index: true
      t.references :user, index: true
      t.string :name, null: false
      t.string :slug, null: false
      t.text :content, null: false

      t.timestamps
    end
  end
end
