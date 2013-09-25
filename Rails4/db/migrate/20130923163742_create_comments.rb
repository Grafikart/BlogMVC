class CreateComments < ActiveRecord::Migration
  def change
    create_table :comments do |t|
      t.references :post, index: true
      t.string :username, null: false
      t.string :mail, null: false
      t.text :content, null: false

      t.timestamps
    end
  end
end
