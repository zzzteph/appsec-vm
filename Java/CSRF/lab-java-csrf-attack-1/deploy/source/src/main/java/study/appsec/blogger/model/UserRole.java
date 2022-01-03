package study.appsec.blogger.model;

import study.appsec.blogger.util.Constants;
import lombok.Getter;
import lombok.Setter;
import lombok.experimental.Accessors;
import org.hibernate.annotations.Cache;
import org.hibernate.annotations.*;

import javax.persistence.Entity;
import javax.persistence.Table;
import javax.persistence.*;
import java.util.HashSet;
import java.util.Set;

@Setter
@Getter
@Accessors(chain = true)

@Entity
@Table(name = "`user_role`")
@Cache(usage = CacheConcurrencyStrategy.READ_WRITE)
public class UserRole extends BaseModel {

    public static final String ROLE_ADMIN = "ADMIN";
    public static final String ROLE_USER = "USER";

    @Column(unique = true)
    private String name;

    @Fetch(FetchMode.SELECT)
    @BatchSize(size = Constants.HIBERNATE_BATCH_SIZE)
    @Cache(usage = CacheConcurrencyStrategy.READ_WRITE)
    @ManyToMany(mappedBy = "roles", fetch = FetchType.LAZY)
    private Set<User> accounts = new HashSet<>();

}
