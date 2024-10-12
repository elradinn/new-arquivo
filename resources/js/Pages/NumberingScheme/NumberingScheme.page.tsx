import { useState } from "react";
import { Head, router } from "@inertiajs/react";
import { IconSearch } from "@tabler/icons-react";
import { Flex, rem, Stack, Text, TextInput } from "@mantine/core";
import { DataTable } from "mantine-datatable";
import { NumberingScheme, NumberingSchemePageProps } from "@/types";
import { AdminLayout } from "@/Layouts/AdminLayout/AdminLayout";

export default function NumberingSchemePage({
    auth,
    numberingScheme,
    filters,
}: NumberingSchemePageProps) {
    const [selectedRecord, setSelectedRecord] = useState<NumberingScheme[]>([]);

    const [page, setPage] = useState(numberingScheme.current_page);
    const [search, setSearch] = useState(filters.search || "");

    const handleSearch = (search: string) => {
        router.get("/activity-log", { search }, { preserveState: true, replace: true });
    };

    const handleonPageChange = (page: number) => {
        const newUrl = numberingScheme.links.find(
            (link: { label: string; url: string }) => link.label === page.toString(),
        )?.url;
        if (newUrl) {
            router.visit(newUrl);
        }
    };

    return (
        <AdminLayout user={auth.user}>
            <Head title="Activity Log" />
            <Stack px={8} gap={24} py={8}>
                <Text component="h2" size="xl" fw={600} c="gray.8">
                    Numbering Scheme
                </Text>

                <Flex
                    justify="space-between"
                    direction={{ base: "column", md: "row" }}
                    gap={{ base: 12, md: 0 }}
                >
                    <TextInput
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
                    />
                </Flex>

                <DataTable
                    pinLastColumn
                    withTableBorder
                    shadow="xs"
                    borderRadius="sm"
                    withRowBorders={false}
                    highlightOnHover
                    verticalSpacing="md"
                    totalRecords={numberingScheme.total}
                    recordsPerPage={numberingScheme.per_page}
                    page={page}
                    onPageChange={(p) => {
                        setPage(p);
                        handleonPageChange(p);
                    }}
                    columns={[
                        { accessor: "name", noWrap: true },
                        { accessor: "description", noWrap: true },
                        { accessor: "folder", noWrap: true },
                    ]}
                    records={numberingScheme.data}
                    selectedRecords={selectedRecord}
                    onSelectedRecordsChange={setSelectedRecord}
                />
            </Stack>
        </AdminLayout>
    );
}
