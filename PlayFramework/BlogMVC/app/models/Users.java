package models;

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
  public String password;
}
