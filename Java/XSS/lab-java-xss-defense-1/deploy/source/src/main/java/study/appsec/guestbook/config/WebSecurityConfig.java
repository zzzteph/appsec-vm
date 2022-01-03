package study.appsec.guestbook.config;

import study.appsec.guestbook.model.UserRole;
import lombok.RequiredArgsConstructor;
import org.springframework.context.annotation.Bean;
import org.springframework.context.annotation.Configuration;
import org.springframework.security.config.annotation.authentication.builders.AuthenticationManagerBuilder;
import org.springframework.security.config.annotation.web.builders.HttpSecurity;
import org.springframework.security.config.annotation.web.configuration.EnableWebSecurity;
import org.springframework.security.config.annotation.web.configuration.WebSecurityConfigurerAdapter;
import org.springframework.security.crypto.bcrypt.BCryptPasswordEncoder;
import org.springframework.security.crypto.password.PasswordEncoder;

@Configuration
@EnableWebSecurity
@RequiredArgsConstructor
public class WebSecurityConfig extends WebSecurityConfigurerAdapter {

    public static final String ADMIN_PASSWORD = "AKSJdh7823g8t329h3t";

    @Override
    protected void configure(HttpSecurity http) throws Exception {
        http
            .csrf().disable()
            .authorizeRequests()
            .antMatchers("/admin/**").hasRole(UserRole.ROLE_ADMIN)
            .antMatchers("/static/**").permitAll()
            .antMatchers("/*", "/login*", "/error*").permitAll()
            .antMatchers("/post/*").permitAll()
            .anyRequest().authenticated()
            .and()
            .formLogin().disable()
            .logout().logoutSuccessUrl("/home")
            .deleteCookies("JSESSIONID");
    }

    @Bean
    public PasswordEncoder passwordEncoder() {
        return new BCryptPasswordEncoder();
    }

    @Override
    protected void configure(AuthenticationManagerBuilder auth) throws Exception {
        auth.inMemoryAuthentication()
            .withUser("admin")
            .password(passwordEncoder().encode(ADMIN_PASSWORD))
            .roles(UserRole.ROLE_ADMIN);
    }
}
