import { Head, Link } from "@inertiajs/react";
import { PageProps } from "@/types";
import { Anchor, Box, Breadcrumbs, Button, Grid, Group, Paper, Stack, Text } from "@mantine/core";
import { AdminLayout } from "@/Layouts/AdminLayout/AdminLayout";
import {
    IconChevronRight,
    IconFile,
    IconGitBranch,
    IconLock,
    IconUpload,
} from "@tabler/icons-react";
import Toolbar from "@/Components/Toolbar/Toolbar";
import { DataTable } from "mantine-datatable";

const mockAuditLog = [
    {
        date: "16 Jun 2024",
        time: "11:49 A.M",
        user: "John Doe",
        action: "Added file",
    },
    {
        date: "16 Jun 2024",
        time: "12:15 P.M",
        user: "Jane Smith",
        action: "Edited document",
    },
    {
        date: "16 Jun 2024",
        time: "01:03 P.M",
        user: "Alice Johnson",
        action: "Deleted file",
    },
    {
        date: "17 Jun 2024",
        time: "09:30 A.M",
        user: "Bob Brown",
        action: "Uploaded image",
    },
    {
        date: "17 Jun 2024",
        time: "10:45 A.M",
        user: "Carol White",
        action: "Moved file",
    },
    {
        date: "17 Jun 2024",
        time: "02:22 P.M",
        user: "David Lee",
        action: "Renamed file",
    },
    {
        date: "18 Jun 2024",
        time: "08:55 A.M",
        user: "Emily Clark",
        action: "Added comment",
    },
    {
        date: "18 Jun 2024",
        time: "11:12 A.M",
        user: "Frank Moore",
        action: "Shared file",
    },
];

export default function DocumentPropertiesPage({ auth }: PageProps) {
    return (
        <AdminLayout user={auth.user} toolbar={<Toolbar fileSelected={false} page="my-files" />}>
            <Head title="Customization" />
            <Box px={8} py={8} mb={48}>
                <Breadcrumbs separator={<IconChevronRight size={16} />}>
                    <Anchor component={Link} href="#">
                        Home
                    </Anchor>
                    <Anchor component={Link} href="#">
                        Administrative
                    </Anchor>
                    <Anchor component={Link} href="#">
                        Sample Document.pdf
                    </Anchor>
                </Breadcrumbs>
            </Box>
            <Grid>
                <Grid.Col span={8}>
                    <Stack px={8} py={8} gap={48} mb={48}>
                        <Group>
                            <IconFile size={56} stroke={1} color="gray" />
                            <Text fw={500}>Sample Document.pdf</Text>
                        </Group>

                        <Group justify="space-between" w={700}>
                            <div>
                                <Text size="sm" fw="bold">
                                    Document ID
                                </Text>
                                <Text size="sm">OoXnr08TUw</Text>
                            </div>
                            <div>
                                <Text size="sm" fw="bold">
                                    Date
                                </Text>
                                <Text size="sm">16 Jun 2024</Text>
                            </div>
                            <div>
                                <Text size="sm" fw="bold">
                                    Document Number
                                </Text>
                                <Text size="sm">SE151672414166</Text>
                            </div>
                        </Group>

                        <Stack gap={12}>
                            <Text size="sm" fw="bold">
                                Audit Log
                            </Text>

                            <DataTable
                                textSelectionDisabled
                                columns={[
                                    { accessor: "date" },
                                    { accessor: "time" },
                                    { accessor: "user" },
                                    { accessor: "action" },
                                ]}
                                records={mockAuditLog}
                                highlightOnHover
                                verticalSpacing="lg"
                                horizontalSpacing="xl"
                                withTableBorder
                            />
                        </Stack>
                    </Stack>
                </Grid.Col>
                <Grid.Col span={3} offset={1}>
                    <Paper withBorder p={20}>
                        <Text c="dimmed" fw={500}>
                            Options
                        </Text>

                        <Button
                            variant="subtle"
                            color="blue.5"
                            leftSection={<IconLock size={18} />}
                            fullWidth
                            justify="left"
                        >
                            Lock File
                        </Button>

                        <Button
                            variant="subtle"
                            color="blue.5"
                            leftSection={<IconUpload size={18} />}
                            fullWidth
                            justify="left"
                        >
                            Upload New Version
                        </Button>

                        <Button
                            variant="subtle"
                            color="blue.5"
                            leftSection={<IconGitBranch size={18} />}
                            fullWidth
                            justify="left"
                        >
                            Start Approval Process
                        </Button>
                    </Paper>
                </Grid.Col>
            </Grid>
        </AdminLayout>
    );
}
