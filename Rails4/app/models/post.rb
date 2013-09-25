class Post < ActiveRecord::Base
  extend FriendlyId
  friendly_id :name, use: :slugged

  belongs_to :category
  belongs_to :user
  has_many :comments

  validates :name, presence: true
  validates :content, presence: true
  validates :category, presence: true
  validates :user, presence: true

  after_create :set_post_count
  after_destroy :set_post_count

  def set_post_count
    category.post_count = category.posts.count
    category.save
  end
end
