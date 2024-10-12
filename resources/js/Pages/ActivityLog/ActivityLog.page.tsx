import { useState } from "react";
import { Head, router } from "@inertiajs/react";
import { IconSearch } from "@tabler/icons-react";
import { Flex, rem, Stack, Text, TextInput } from "@mantine/core";
import { DataTable } from "mantine-datatable";
import { ActivityLog, ActivityLogPageProps } from "@/types";
import { Authenticated } from "@/Modules/Common/Layouts/AuthenticatedLayout/Authenticated";
import FilterButton from "./Filter";

export default function ActivityLogPage({ auth, activityLog, filters }: ActivityLogPageProps) {
    const [selectedRecord, setSelectedRecord] = useState<ActivityLog[]>([]);

    // const [page, setPage] = useState(activityLog.current_page);
    // const [search, setSearch] = useState(filters.search || "");

    // const handleSearch = (search: string) => {
    //     router.get("/activity-log", { search }, { preserveState: true, replace: true });
    // };

    // const handleonPageChange = (page: number) => {
    //     const newUrl = activityLog.links.find(
    //         (link: { label: string; url: string }) => link.label === page.toString(),
    //     )?.url;
    //     if (newUrl) {
    //         router.visit(newUrl);
    //     }
    // };

    return (
        <Authenticated>
            <Head title="Activity Log" />
            <Stack px={8} gap={24} py={8}>
                <Text component="h2" size="xl" fw={600} c="gray.8">
                    Activity Log
                </Text>

                <Flex
                    justify="space-between"
                    direction={{ base: "column", md: "row" }}
                    gap={{ base: 12, md: 0 }}
                >
                    {/* <TextInput
                        w={{ md: 400 }}
                        placeholder="Search"
                        leftSection={
                            <IconSearch style={{ width: rem(16), height: rem(16) }} stroke={1.5} />
                        }
                        value={search}
                        onChange={(e) => {
                            setSearch(e.target.value);
                            handleSearch(e.target.value);
                        }}
                    /> */}

                    <FilterButton />
                </Flex>
                {/* 
                <DataTable
                    pinLastColumn
                    withTableBorder
                    shadow="xs"
                    borderRadius="sm"
                    withRowBorders={false}
                    highlightOnHover
                    verticalSpacing="md"
                    totalRecords={activityLog.total}
                    recordsPerPage={activityLog.per_page}
                    page={page}
                    onPageChange={(p) => {
                        setPage(p);
                        handleonPageChange(p);
                    }}
                    columns={[
                        { accessor: "description", noWrap: true },
                        { accessor: "object_type", noWrap: true },
                        { accessor: "object", noWrap: true },
                        { accessor: "action", noWrap: true },
                    ]}
                    records={activityLog.data}
                    selectedRecords={selectedRecord}
                    onSelectedRecordsChange={setSelectedRecord}
                /> */}
            </Stack>
        </Authenticated>
    );
}
