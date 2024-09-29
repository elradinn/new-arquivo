import { Anchor, Button, Checkbox, Flex, Stack, TextInput } from "@mantine/core";
import { Link } from "@inertiajs/react";
import { useLoginForm } from "../Hooks/use-login-form";

export default function LoginForm({ canResetPassword }: { canResetPassword: boolean }) {
    const { data, setData, submit, processing, errors } = useLoginForm();

    return (
        <form onSubmit={submit}>
            <Stack gap={16}>
                <TextInput
                    id="email"
                    type="email"
                    name="email"
                    value={data.email}
                    autoComplete="username"
                    leftSectionPointerEvents="none"
                    label="Email"
                    onChange={(e) => setData("email", e.target.value)}
                    error={errors.email}
                />

                <TextInput
                    id="password"
                    type="password"
                    name="password"
                    value={data.password}
                    autoComplete="current-password"
                    leftSectionPointerEvents="none"
                    label="Password"
                    onChange={(e) => setData("password", e.target.value)}
                    error={errors.password}
                />

                <Flex align="center">
                    <Checkbox
                        name="remember"
                        checked={data.remember}
                        onChange={(e) => setData("remember", e.target.checked)}
                        label="Remember me"
                    />
                </Flex>

                <Flex align="center" justify="end">
                    {canResetPassword && (
                        <Anchor component={Link} href={route("password.request")} size="sm">
                            Forgot your password?
                        </Anchor>
                    )}
                    <Button ml={16} type="submit" loading={processing}>
                        Log in
                    </Button>
                </Flex>
            </Stack>
        </form>
    );
}