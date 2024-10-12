import { useState } from "react";
import { Head } from "@inertiajs/react";
import { Button, Flex, rem, Stack, Text, TextInput } from "@mantine/core";
import { IconPlus, IconSearch } from "@tabler/icons-react";
import { useDisclosure } from "@mantine/hooks";
import { Authenticated } from "@/Modules/Common/Layouts/AuthenticatedLayout/Authenticated";
import CreateMetadataForm from "@/Modules/Metadata/Forms/CreateMetadataForm";
import UpdateMetadataForm from "@/Modules/Metadata/Forms/UpdateMetadataForm";
import DeleteMetadataForm from "@/Modules/Metadata/Forms/DeleteMetadataForm";
import MetadataTable from "@/Modules/Metadata/Components/MetadataTable";
import { useMetadataSearch } from "@/Modules/Metadata/Hooks/use-search-metadata";
import { useMetadataPagination } from "@/Modules/Metadata/Hooks/use-paginate-metadata";
import { MetadataResourceData } from "@/Modules/Metadata/Types/MetadataResourceData";
import { PaginationData, Filters } from "@/Modules/Metadata/Types/MetadataPageTypes";

interface IProps {
    metadata: PaginationData;
    filters: Filters;
}

export default function MetadataPage({ metadata, filters }: IProps) {
    const [selectedRecord, setSelectedRecord] = useState<MetadataResourceData[]>([]);
    const [currentMetadata, setCurrentMetadata] = useState<MetadataResourceData>();

    const { search, setSearch, handleSearch } = useMetadataSearch(filters.search || "");
    const { page, setPage, handlePageChange } = useMetadataPagination(metadata.current_page);

    const [addMetadataOpened, { open: openAddMetadata, close: closeAddMetadata }] = useDisclosure(false);
    const [editMetadataOpened, { open: openEditMetadata, close: closeEditMetadata }] = useDisclosure(false);
    const [deleteMetadataOpened, { open: openDeleteMetadata, close: closeDeleteMetadata }] = useDisclosure(false);

    const handleEditMetadata = (metadata: MetadataResourceData) => {
        setCurrentMetadata(metadata);
        openEditMetadata();
    };

    const handleDeleteMetadata = (metadata: MetadataResourceData) => {
        setCurrentMetadata(metadata);
        openDeleteMetadata();
    };

    return (
        <Authenticated>
            <Head title="Metadata" />
            <Stack px={8} gap={24} py={8}>
                <Text component="h2" size="xl" fw={600} c="gray.8">
                    Metadata
                </Text>
                <Flex justify="space-between" direction={{ base: "column", md: "row" }} gap={{ base: 12, md: 0 }}>
                    <TextInput
                        w={{ md: 400 }}
                        placeholder="Search"
                        leftSection={<IconSearch style={{ width: rem(16), height: rem(16) }} stroke={1.5} />}
                        value={search}
                        onChange={(e) => {
                            setSearch(e.target.value);
                            handleSearch(e.target.value);
                        }}
                    />
                    <Button leftSection={<IconPlus size={14} />} onClick={openAddMetadata}>
                        Add New Metadata
                    </Button>
                </Flex>
                <MetadataTable
                    metadata={metadata.data}
                    total={metadata.total}
                    perPage={metadata.per_page}
                    page={page}
                    onPageChange={(p) => {
                        setPage(p);
                        handlePageChange(p, metadata.links);
                    }}
                    onEdit={handleEditMetadata}
                    onDelete={handleDeleteMetadata}
                    selectedRecords={selectedRecord}
                    onSelectedRecordsChange={setSelectedRecord}
                />
            </Stack>

            <CreateMetadataForm isOpened={addMetadataOpened} close={closeAddMetadata} />
            <UpdateMetadataForm isOpened={editMetadataOpened} close={closeEditMetadata} metadata={currentMetadata} />
            <DeleteMetadataForm isOpened={deleteMetadataOpened} close={closeDeleteMetadata} metadata={currentMetadata} />
        </Authenticated>
    );
}
