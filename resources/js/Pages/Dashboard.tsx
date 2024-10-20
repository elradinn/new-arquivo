import { Head } from "@inertiajs/react";
import { Group, Stack, Text } from "@mantine/core";
import { Authenticated } from "@/Modules/Common/Layouts/AuthenticatedLayout/Authenticated";
import { StatCards } from "@/Modules/Common/Components/StatCards/StatCards";
import { DataTable } from "mantine-datatable";
import { ItemIcon } from "@/Modules/Common/Components/ItemIcon/ItemIcon";

const mockFiles = [
    {
        id: 1,
        name: "Project Proposal.docx",
        owner: "Alice",
        updated_at: "2024-07-21T14:32:00Z",
        size: "32 KB",
        type: "file",
        mime: "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
        is_folder: 0,
    },
    {
        id: 3,
        name: "Meeting Notes.txt",
        owner: "Carol",
        updated_at: "2024-06-15T11:22:00Z",
        size: "12 KB",
        type: "file",
        mime: "text/plain",
        is_folder: 0,
    },
    {
        id: 4,
        name: "Financial Report.pdf",
        owner: "Dave",
        updated_at: "2024-08-10T08:45:00Z",
        size: "256 KB",
        mime: "application/pdf",
        type: "file",
        is_folder: 0,
    },
    {
        id: 6,
        name: "Research Paper.docx",
        owner: "Frank",
        updated_at: "2024-07-25T10:10:00Z",
        size: "40 KB",
        mime: "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
        type: "file",
        is_folder: 0,
    },
];

// TODO: Make this to module Dashboard
export default function DashboardPage() {
    return (
        <Authenticated>
            <Head title="Dashboard" />
            <Stack px={8} gap={48} py={8}>
                <Stack gap={24}>
                    <Text component="h2" size="xl" fw={600} c="gray.8">
                        Dashboard
                    </Text>

                    <StatCards />
                </Stack>

                <Stack gap={24}>
                    <Text c="gray.7" fw={500}>
                        Recent Documents
                    </Text>

                    <DataTable
                        textSelectionDisabled
                        columns={[
                            {
                                accessor: "name",
                                render: ({ mime, type, name }) => (
                                    <Group align="center" gap={12}>
                                        <ItemIcon mime={mime} isFolder={type === "folder"} />
                                        <span>{name}</span>
                                    </Group>
                                ),
                            },
                            { accessor: "owner" },
                            {
                                accessor: "updated_at",
                                title: "Last Modified",
                            },
                            { accessor: "size" },
                        ]}
                        records={mockFiles}
                        highlightOnHover
                        verticalSpacing="lg"
                        horizontalSpacing="xl"
                    />
                </Stack>
            </Stack>
        </Authenticated>
    );
}