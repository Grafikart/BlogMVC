require 'digest/sha1'
class User < ActiveRecord::Base
  validates :username, presence: true, uniqueness: true

  has_many :posts
  before_create :crypter_pass

  private

    def crypter_pass
      self.password = Digest::MD5.hexdigest("BlogMVC" + self.password)
    end
end
