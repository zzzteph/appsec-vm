package study.appsec.blogger.service.security;

import study.appsec.blogger.model.User;
import study.appsec.blogger.model.UserRole;
import study.appsec.blogger.repository.UserRepository;
import lombok.RequiredArgsConstructor;
import org.springframework.security.core.GrantedAuthority;
import org.springframework.security.core.authority.SimpleGrantedAuthority;
import org.springframework.security.core.userdetails.UserDetails;
import org.springframework.security.core.userdetails.UserDetailsService;
import org.springframework.security.core.userdetails.UsernameNotFoundException;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;

import java.util.List;
import java.util.stream.Collectors;

@Service
@RequiredArgsConstructor
public class UserDetailsServiceImpl implements UserDetailsService {

    private final UserRepository userRepository;

    @Transactional(readOnly = true)
    @Override
    public UserDetails loadUserByUsername(String username) throws UsernameNotFoundException {
        User user = userRepository.findByUsername(username);
        if (user == null) {
            throw new UsernameNotFoundException("User not found.");
        }
        List<GrantedAuthority> authorities = user.getRoles().stream()
            .map(UserRole::getName)
            .map(SimpleGrantedAuthority::new)
            .collect(Collectors.toList());
        return new UserDetailsImpl(user.getUsername(), user.getPassword(), authorities);
    }

}
