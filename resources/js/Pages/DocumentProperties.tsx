import { Head, Link } from "@inertiajs/react";
import { Anchor, Box, Breadcrumbs, Button, Grid, Group, Paper, Stack, Text } from "@mantine/core";
import { Authenticated } from "@/Modules/Common/Layouts/AuthenticatedLayout/Authenticated";
import {
    IconChevronRight,
    IconFile,
    IconGitBranch,
    IconLock,
    IconUpload,
} from "@tabler/icons-react";
import Toolbar from "@/Modules/Common/Components/Toolbar/Toolbar";
import { DataTable } from "mantine-datatable";
import { DocumentResourceData } from "@/Modules/Document/Types/DocumentResourceData";
import { ItemAncestorsResourceData } from "@/Modules/Item/Types/ItemAncestorsResourceData";
import ItemBreadcrumbs from "@/Modules/Item/Components/ItemBreadcrumbs";
import { ActivityLogResourceData } from "@/Modules/ActivityLog/Types/ActivityLogResourceData";

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

interface IProps {
    document: DocumentResourceData;
    itemAncestors: ItemAncestorsResourceData[];
    activityLog: ActivityLogResourceData[]
}

export default function DocumentPropertiesPage({ document, itemAncestors, activityLog }: IProps) {
    return (
        <Authenticated toolbar={<Toolbar page="folder" />}>
            <Head title="Document Properties" />
            <Box px={8} py={8} mb={48}>
                <ItemBreadcrumbs ancestors={itemAncestors} />
            </Box>
            <Grid>
                <Grid.Col span={8}>
                    <Stack px={8} py={8} gap={48} mb={48}>
                        <Group>
                            <IconFile size={56} stroke={1} color="gray" />
                            <Text fw={500}>{document.name}</Text>
                        </Group>

                        <Group justify="space-between" w={700}>
                            <div>
                                <Text size="sm" fw="bold">
                                    Document ID
                                </Text>
                                <Text size="sm">{document.item_id}</Text>
                            </div>
                            <div>
                                <Text size="sm" fw="bold">
                                    Date
                                </Text>
                                <Text size="sm">{document.created_at}</Text>
                            </div>
                            <div>
                                <Text size="sm" fw="bold">
                                    Document Number
                                </Text>
                                <Text size="sm">{document.document_number}</Text>
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
                                    { accessor: "user_name", title: "User" },
                                    { accessor: "description", title: "Action" },
                                ]}
                                records={activityLog}
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
        </Authenticated>
    );
}
