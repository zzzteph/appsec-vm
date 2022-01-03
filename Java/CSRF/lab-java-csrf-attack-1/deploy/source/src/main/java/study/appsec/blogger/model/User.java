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
import javax.validation.constraints.Pattern;
import java.util.HashSet;
import java.util.Set;
import java.util.stream.Collectors;

@Setter
@Getter
@Accessors(chain = true)

@Entity
@Table(name = "`user`")
@Cache(usage = CacheConcurrencyStrategy.READ_WRITE)
public class User extends BaseModel {

    @Pattern(regexp = "^[a-z0-9\\s]{4,10}$")
    @Column(unique = true)
    private String username;

    @Column
    private String password;

    @Fetch(FetchMode.SELECT)
    @BatchSize(size = Constants.HIBERNATE_BATCH_SIZE)
    @Cache(usage = CacheConcurrencyStrategy.READ_WRITE)
    @ManyToMany(fetch = FetchType.LAZY)
    @JoinTable(
        name = "`user_user_role`",
        joinColumns = @JoinColumn(name = "`user_id`"),
        inverseJoinColumns = @JoinColumn(name = "`role_id`")
    )
    private Set<UserRole> roles = new HashSet<>();

    public boolean hasRole(String roleName) {
        return getRoles().stream()
            .map(UserRole::getName)
            .collect(Collectors.toSet())
            .contains(roleName);
    }

}
