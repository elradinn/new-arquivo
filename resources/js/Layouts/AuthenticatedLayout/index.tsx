import { PropsWithChildren } from "react";
import ApplicationLogo from "@/Components/ApplicationLogo";
import NavLink from "@/Components/NavLink";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink";
import { Link } from "@inertiajs/react";
import { User } from "@/types";
import {
    Box,
    Burger,
    Container,
    Flex,
    Group,
    Menu,
    rem,
    Stack,
    Text,
    UnstyledButton,
} from "@mantine/core";
import { IconChevronDown, IconLogout, IconUser } from "@tabler/icons-react";
import classes from "./AuthenticatedLayout.module.css";
import { useDisclosure } from "@mantine/hooks";

export default function Authenticated({
    user,
    header,
    children,
}: PropsWithChildren<{ user: User; header?: string }>) {
    const [opened, { toggle }] = useDisclosure();

    return (
        <div className={classes.screen}>
            <nav className={classes.header}>
                <Container className={classes.headerContainer}>
                    <Flex justify="space-between" h={64}>
                        <Flex>
                            <Flex align="center">
                                <Link href="/">
                                    <ApplicationLogo height={36} width={36} />
                                </Link>
                            </Flex>

                            <div className={classes.navLink}>
                                <NavLink
                                    href={route("dashboard")}
                                    active={route().current("dashboard")}
                                >
                                    Dashboard
                                </NavLink>
                            </div>
                        </Flex>

                        <div className={classes.flexContainer}>
                            <div className={classes.relativeContainer}>
                                <Menu
                                    width={200}
                                    transitionProps={{
                                        transition: "pop-top-right",
                                    }}
                                    position="bottom-end"
                                >
                                    <Menu.Target>
                                        <UnstyledButton>
                                            <Group gap={7}>
                                                <Text size="sm" lh={1} mr={3}>
                                                    {user.name}
                                                </Text>
                                                <IconChevronDown
                                                    style={{
                                                        width: rem(18),
                                                        height: rem(18),
                                                    }}
                                                    stroke={1.5}
                                                />
                                            </Group>
                                        </UnstyledButton>
                                    </Menu.Target>
                                    <Menu.Dropdown>
                                        <Menu.Item
                                            component={Link}
                                            leftSection={
                                                <IconUser
                                                    style={{
                                                        width: rem(14),
                                                        height: rem(14),
                                                    }}
                                                />
                                            }
                                            href={route("profile.edit")}
                                        >
                                            Profile
                                        </Menu.Item>
                                        <Menu.Item
                                            component={Link}
                                            leftSection={
                                                <IconLogout
                                                    style={{
                                                        width: rem(14),
                                                        height: rem(14),
                                                    }}
                                                />
                                            }
                                            href={route("logout")}
                                            as="button"
                                            method="post"
                                        >
                                            Logout
                                        </Menu.Item>
                                    </Menu.Dropdown>
                                </Menu>
                            </div>
                        </div>

                        <Flex
                            align="center"
                            hiddenFrom="sm"
                            style={{ marginInlineEnd: "0.5rem" }}
                        >
                            <Burger
                                opened={opened}
                                onClick={toggle}
                                hiddenFrom="sm"
                                color="gray"
                            />
                        </Flex>
                    </Flex>
                </Container>

                <Box
                    style={opened ? { display: "block" } : { display: "none" }}
                    hiddenFrom="sm"
                >
                    <Stack pt={8} pb={16} gap={4}>
                        <ResponsiveNavLink
                            href={route("dashboard")}
                            active={route().current("dashboard")}
                        >
                            Dashboard
                        </ResponsiveNavLink>
                    </Stack>

                    <Box
                        pt={16}
                        style={{
                            borderTopWidth: 1,
                            borderColor: "var(--mantine-color-gray-2)",
                        }}
                    >
                        <Box px={16}>
                            <Text fw={500}>{user.name}</Text>

                            <Text
                                size="sm"
                                style={{ color: "var(--mantine-color-gray-7" }}
                            >
                                {user.email}
                            </Text>
                        </Box>

                        <Stack mt={16} gap={4}>
                            <ResponsiveNavLink href={route("profile.edit")}>
                                Profile
                            </ResponsiveNavLink>
                            <ResponsiveNavLink
                                method="post"
                                href={route("logout")}
                                as="button"
                            >
                                Log Out
                            </ResponsiveNavLink>
                        </Stack>
                    </Box>
                </Box>
            </nav>

            {header && (
                <header className={classes.subheader}>
                    <div className={classes.subheaderContainer}>
                        <Text size="xl" fw={500}>
                            {header}
                        </Text>
                    </div>
                </header>
            )}

            <main>{children}</main>
        </div>
    );
}
