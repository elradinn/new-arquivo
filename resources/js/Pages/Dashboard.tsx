import { Head, Link } from "@inertiajs/react";
import { Group, Stack, Text, Button } from "@mantine/core";
import { Authenticated } from "@/Modules/Common/Layouts/AuthenticatedLayout/Authenticated";
import { DataTable } from "mantine-datatable";
import { ItemIcon } from "@/Modules/Common/Components/ItemIcon/ItemIcon";
import { StatCards } from "@/Modules/Common/Components/StatCards/StatCards";
import { DashboardResource } from "@/Modules/Dashboard/Types/DashboardResource";
import { IconArrowRight } from "@tabler/icons-react";

interface DashboardPageProps {
    dashboard: DashboardResource;
}

export default function DashboardPage({ dashboard }: DashboardPageProps) {
    return (
        <Authenticated>
            <Head title="Dashboard" />
            <Stack px={8} gap={48} py={8}>
                <Stack gap={24}>
                    <Group align="center" justify="space-between">
                        <Text component="h2" size="xl" fw={600} color="gray.8">
                            Dashboard
                        </Text>
                        <Button
                            component={Link}
                            href="/dashboard/reports"
                            variant="subtle"
                            color="blue"
                            rightSection={<IconArrowRight size={16} />}
                        >
                            Go to Reports
                        </Button>
                    </Group>

                    <StatCards dashboard={dashboard} />
                </Stack>

                <Stack gap={24}>
                    <Text c="gray.7" fw={500}>
                        Recently Uploaded Documents
                    </Text>

                    <DataTable
                        textSelectionDisabled
                        columns={[
                            {
                                accessor: "name",
                                render: ({ name, status }) => (
                                    <Group align="center" gap={12}>
                                        <ItemIcon mime="application/pdf" isFolder={false} />
                                        <span>{name}</span>
                                        <Text size="xs" color="dimmed">
                                            {status}
                                        </Text>
                                    </Group>
                                ),
                            },
                            { accessor: "status" },
                            { accessor: "date_uploaded", title: "Date Uploaded" },
                        ]}
                        records={dashboard.recently_uploaded_documents}
                        highlightOnHover
                        verticalSpacing="lg"
                        horizontalSpacing="xl"
                    />
                </Stack>
            </Stack>
        </Authenticated>
    );
}