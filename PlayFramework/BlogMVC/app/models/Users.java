package models;

import play.db.jpa.JPA;

import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.Id;

/**
 * Created by greg on 16/09/2016.
 */

@Entity
public class Users {

  @Id
  @GeneratedValue
  public Long id;
  public String username;
  //Replace by Hash
  public String password;

  public static Users find(String username) {
    try {
      return JPA.em().createQuery("SELECT u FROM Users u WHERE u.username = :username", Users.class)
          .setParameter("username", username)
          .getSingleResult();
    } catch (Exception e) {
      return null;
    }
  }
}
