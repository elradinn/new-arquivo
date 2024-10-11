import { Link } from "@inertiajs/react";
import {
    Group,
    Box,
    Text,
    Divider,
    ActionIcon,
    Menu,
} from "@mantine/core";
import {
    IconTrash,
    IconFolderFilled,
    IconLayoutDashboard,
    IconDotsVertical,
} from "@tabler/icons-react";
import classes from "./Sidebar.module.css";
import OfficeLogo from "../OfficeLogo/OfficeLogo";

const NAV_LINKS = [
    {
        label: "Dashboard",
        icon: IconLayoutDashboard,
        href: "/dashboard",
    },
    {
        label: "Trash",
        icon: IconTrash,
        href: "/trash",
    },
];

const workspaces = [
    {
        id: 1,
        name: "Workspace 1",
    },
    {
        id: 2,
        name: "Workspace 2",
    },
    {
        id: 3,
        name: "Workspace 3",
    },
];

const Sidebar: React.FC = () => {

    const renderNavLinks = NAV_LINKS.map(({ label, icon: Icon, href }) => (
        <Link
            className={classes.link}
            data-active={route().current(label.toLowerCase()) || undefined}
            href={href}
            key={label}
        >
            <Icon className={classes.linkIcon} stroke={1.5} />
            <span>{label}</span>
        </Link>
    ));

    const renderWorkspaceLinks = workspaces.map((workspace) => (
        <div
            className={classes.workspaceLinkWrapper}
            key={workspace.id}
            data-active={route().current("index", workspace.id) || undefined}
        >
            <Link className={classes.workspaceLinkDesign} href={`/folder/index/${workspace.id}`}>
                <div className={classes.workspaceLinkContent}>
                    <IconFolderFilled className={classes.linkIcon} stroke={1.5} />
                    <span>{workspace.name}</span>
                </div>
            </Link>
            <Menu width={200} position="right-start">
                <Menu.Target>
                    <ActionIcon className={classes.actionIcon} variant="transparent" size={32}>
                        <IconDotsVertical className={classes.settingsIcon} stroke={1.5} />
                    </ActionIcon>
                </Menu.Target>
            </Menu>
        </div>
    ));

    return (
        <>
            <nav className={classes.navbar}>
                <div className={classes.navbarMain}>
                    <Group className={classes.header}>
                        <Link href="/dashboard">
                            <OfficeLogo h={48} w={48} />
                        </Link>
                    </Group>
                    <Box mb={12}>{renderNavLinks}</Box>
                    <Divider />
                    <Group justify="space-between" p="sm" mt={12}>
                        <Text size="xs" fw={500} c="dimmed">
                            Workspaces
                        </Text>
                    </Group>
                    <div className={classes.workspaces}>{renderWorkspaceLinks}</div>
                </div>
            </nav>
        </>
    );
};

export default Sidebar;
