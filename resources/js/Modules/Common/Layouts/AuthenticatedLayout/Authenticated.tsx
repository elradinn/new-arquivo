import Sidebar from "@/Modules/Common/Components/Sidebar/Sidebar";
import { Link, usePage } from "@inertiajs/react";
import {
    ActionIcon,
    AppShell,
    Avatar,
    Burger,
    Button,
    Center,
    Divider,
    Flex,
    Group,
    Indicator,
    Menu,
    rem,
    Stack,
    Text,
    TextInput,
} from "@mantine/core";
import { useDisclosure } from "@mantine/hooks";
import {
    IconBell,
    IconInbox,
    IconLayoutGrid,
    IconLogout,
    IconSearch,
    IconUser,
} from "@tabler/icons-react";
import { PageProps } from "../../Types";

interface IProps {
    children: React.ReactNode;
    toolbar?: React.ReactNode;
}

export function Authenticated({ children, toolbar }: IProps) {
    const [opened, { toggle }] = useDisclosure();

    const user = usePage<PageProps>().props.auth.user;

    return (
        <AppShell
            layout="alt"
            header={{ height: toolbar ? 120 : 60 }}
            navbar={{
                width: 250,
                breakpoint: "sm",
                collapsed: { mobile: !opened },
            }}
            padding="md"
        >
            <AppShell.Header>
                <Flex h={toolbar ? "50%" : "100%"} px="md" justify="space-between" align="center">
                    <Burger opened={opened} onClick={toggle} hiddenFrom="sm" size="sm" />

                    <TextInput
                        leftSection={<IconSearch size={16} />}
                        placeholder="Search for documents or folders"
                        w={{ base: 300, lg: 550 }}
                        visibleFrom="sm"
                        variant="filled"
                    />

                    <Group align="center" gap={8}>
                        <Button
                            component={Link}
                            href="#"
                            leftSection={<IconLayoutGrid stroke={1.5} />}
                            radius="md"
                            variant="light"
                        >
                            Admin Tools
                        </Button>
                        <Menu
                            width={200}
                            transitionProps={{
                                transition: "pop-top-right",
                            }}
                            position="bottom-end"
                        >
                            <Menu.Target>
                                <ActionIcon variant="subtle" color="gray" size="xl">
                                    <Indicator disabled>
                                        <IconBell size={24} />
                                    </Indicator>
                                </ActionIcon>
                            </Menu.Target>
                            <Menu.Dropdown>
                                <Center h={200}>
                                    <Stack align="center" c="dimmed">
                                        <IconInbox />
                                        <Text c="dimmed">No notifications</Text>
                                    </Stack>
                                </Center>
                            </Menu.Dropdown>
                        </Menu>
                        <Menu
                            width={200}
                            transitionProps={{
                                transition: "pop-top-right",
                            }}
                            position="bottom-end"
                        >
                            <Menu.Target>
                                <ActionIcon variant="subtle" color="gray" size="xl" radius="xl">
                                    <Avatar name={user.name} color="blue" size="md" />
                                </ActionIcon>
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
                    </Group>
                </Flex>

                <Divider />

                {toolbar}
            </AppShell.Header>


            <AppShell.Navbar>
                <Sidebar />
            </AppShell.Navbar>
            <AppShell.Main>{children}</AppShell.Main>
        </AppShell>
    );
}
