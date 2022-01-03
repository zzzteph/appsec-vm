package study.appsec.blogger.util;

@FunctionalInterface
public interface ThrowingRunnable<E extends Exception> extends Runnable {

    @Override
    default void run() {
        try {
            runThrows();
        } catch (Exception e) {
            throw new RuntimeException(e);
        }
    }

    void runThrows() throws E;

    static void throwingRunnable(ThrowingRunnable<Exception> runnable) {
        runnable.run();
    }
}
