package study.appsec.blogger.service;

import study.appsec.blogger.exception.RegisteredMaxUsersException;
import study.appsec.blogger.exception.UserNotFoundException;
import study.appsec.blogger.model.User;
import study.appsec.blogger.model.UserRole;
import study.appsec.blogger.repository.UserRepository;
import study.appsec.blogger.repository.UserRoleRepository;
import lombok.RequiredArgsConstructor;
import org.springframework.security.crypto.password.PasswordEncoder;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;

import javax.annotation.PostConstruct;
import javax.persistence.EntityManager;
import java.security.Principal;
import java.util.Collections;
import java.util.HashSet;

@Service
@RequiredArgsConstructor
public class UserService {

    public static final int MAX_ALLOWED_USERS_COUNT = 5;

    private final UserRepository userRepository;
    private final UserRoleRepository userRoleRepository;
    private final PasswordEncoder passwordEncoder;
    private final EntityManager entityManager;

    private UserRole userRoleForUsers;

    @PostConstruct
    private void init() {
        userRoleForUsers = userRoleRepository.findByName(UserRole.ROLE_USER);
    }

    @Transactional(readOnly = true)
    public User getUser(String username) {
        User user = userRepository.findByUsername(username);
        return checkUserAndReturn(user);
    }

    @Transactional(readOnly = true)
    public User getUser(Principal principal) {
        if (principal == null || principal.getName() == null) {
            throw new UserNotFoundException();
        }
        return getUser(principal.getName());
    }

    @Transactional(readOnly = true)
    public User getUser(Long id) {
        User user = userRepository.findById(id);
        return checkUserAndReturn(user);
    }

    @Transactional(readOnly = true)
    public User findUser(Principal principal) {
        User user;
        try {
            user = getUser(principal);
        } catch (UserNotFoundException e) {
            user = null;
        }
        return user;
    }

    @Transactional
    public User createNewUser(String username, String password) {
        if (!canRegisterNewUser()) {
            throw new RegisteredMaxUsersException();
        }
        User user = new User();
        user.setUsername(username.trim());
        user.setPassword(passwordEncoder.encode(password));
        user.setRoles(new HashSet<>(Collections.singletonList(userRoleForUsers)));
        entityManager.persist(user);
        entityManager.flush();
        return user;
    }

    @Transactional(readOnly = true)
    public boolean canRegisterNewUser() {
        return userRepository.count() < MAX_ALLOWED_USERS_COUNT;
    }

    private User checkUserAndReturn(User user) {
        if (user == null) {
            throw new UserNotFoundException();
        }
        return user;
    }

}
