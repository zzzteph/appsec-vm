package study.appsec.guestbook.util;

import java.util.function.Supplier;

@FunctionalInterface
public interface ThrowingSupplier<T, E extends Exception> extends Supplier<T> {

    @Override
    default T get() {
        try {
            return getThrows();
        } catch (Exception e) {
            throw new RuntimeException(e);
        }
    }

    T getThrows() throws E;

    static <T> T throwingSupplier(ThrowingSupplier<T, Exception> supplier) {
        return supplier.get();
    }
}
