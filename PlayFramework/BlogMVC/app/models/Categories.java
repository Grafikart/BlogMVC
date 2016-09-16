package models;

import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.GenerationType;
import javax.persistence.Id;
import javax.persistence.OneToMany;
import java.util.List;

/**
 * Created by greg on 16/09/2016.
 */

@Entity
public class Categories {

  @Id
  @GeneratedValue(strategy = GenerationType.AUTO)
  public Long id;
  public String name;
  public String slug;
  @OneToMany
  public List<Posts> associatedPost;
}
