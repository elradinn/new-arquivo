import { useState } from "react";
import { Head } from "@inertiajs/react";
import { Stack, Text, Button, Flex, TextInput, rem } from "@mantine/core";
import { IconPlus, IconSearch } from "@tabler/icons-react";
import { Authenticated } from "@/Modules/Common/Layouts/AuthenticatedLayout/Authenticated";
import NumberingSchemeTable from "@/Modules/NumberingScheme/Components/NumberingSchemeTable";
import NumberingSchemeForm from "@/Modules/NumberingScheme/Forms/NumberingSchemeForm";
import { NumberingSchemeResourceData } from "@/Modules/NumberingScheme/Types/NumberingSchemeResourceData";
import { useSearchDataTable } from "@/Modules/Common/Hooks/use-search-datatable";
import { usePaginateDataTable } from "@/Modules/Common/Hooks/use-paginate-datatable";
import { Filters, PaginationData } from "@/Modules/NumberingScheme/Types/NumberingSchemePageTypes";

interface IProps {
    numberingSchemes: PaginationData;
    filters: Filters;
}

export default function NumberingSchemePage({ numberingSchemes, filters }: IProps) {
    const [selectedRecord, setSelectedRecord] = useState<NumberingSchemeResourceData[]>([]);
    const [formOpened, setFormOpened] = useState(false);
    const [editingScheme, setEditingScheme] = useState<NumberingSchemeResourceData | null>(null);

    const { search, setSearch, handleSearch } = useSearchDataTable(filters.search || "", "/numbering-scheme");
    const { page, setPage, handlePageChange } = usePaginateDataTable(numberingSchemes.current_page);

    const closeForm = () => {
        setFormOpened(false);
        setEditingScheme(null);
    };

    const handleEdit = (scheme: NumberingSchemeResourceData) => {
        setEditingScheme(scheme);
        setFormOpened(true);
    };

    return (
        <Authenticated>
            <Head title="Numbering Scheme" />
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

                <NumberingSchemeTable
                    records={numberingSchemes.data}
                    totalRecords={numberingSchemes.total}
                    recordsPerPage={numberingSchemes.per_page}
                    page={page}
                    onPageChange={(p) => {
                        setPage(p);
                        handlePageChange(p, numberingSchemes.links);
                    }}
                    selectedRecords={selectedRecord}
                    onSelectedRecordsChange={setSelectedRecord}
                />

                <NumberingSchemeForm
                    isOpened={formOpened}
                    close={closeForm}
                    initialData={editingScheme || undefined}
                />
            </Stack>
        </Authenticated>
    );
};
