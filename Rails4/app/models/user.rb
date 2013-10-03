require 'digest/sha1'
class User < ActiveRecord::Base
  validates :username, presence: true, uniqueness: true

  has_many :posts
  before_create :crypter_pass

  def self.authenticate username, password
    user = find_by(username: username)
    return nil if user and user.password != User.crypter(password)
    user
  end

  private

    def crypter_pass
      self.password = User.crypter(password)
    end

    def self.crypter pass
      Digest::MD5.hexdigest("BlogMVC" + pass)
    end
end
