import { useState } from "react";
import { Head, router } from "@inertiajs/react";
import { IconEdit, IconPlus, IconSearch, IconTrash } from "@tabler/icons-react";
import { ActionIcon, Box, Button, Flex, Group, rem, Stack, Text, TextInput } from "@mantine/core";
import { DataTable } from "mantine-datatable";
import { useDisclosure } from "@mantine/hooks";
import { Metadata, MetadataPageProps } from "@/types";
import { Authenticated } from "@/Modules/Common/Layouts/AuthenticatedLayout/Authenticated";
import AddMetadataForm from "./AddMetadataForm";
import EditMetadataForm from "./EditMetadataForm";
import DeleteMetadataForm from "./DeleteMetadataForm";

export default function MetadataPage({ auth, metadata, filters }: MetadataPageProps) {
    const [selectedRecord, setSelectedRecord] = useState<Metadata[]>([]);
    const [currentMetadata, setCurrentMetadata] = useState<Metadata | undefined>();

    const [page, setPage] = useState(metadata.current_page);
    // const [search, setSearch] = useState(filters.search || "");

    // const handleSearch = (search: string) => {
    //     router.get("/metadata", { search }, { preserveState: true, replace: true });
    // };

    // const handleonPageChange = (page: number) => {
    //     const newUrl = metadata.links.find(
    //         (link: { label: string; url: string }) => link.label === page.toString(),
    //     )?.url;
    //     if (newUrl) {
    //         router.visit(newUrl);
    //     }
    // };

    const [addMetadataOpened, { open: openAddMetadata, close: closeAddMetadata }] =
        useDisclosure(false);

    const [editMetadataOpened, { open: openEditMetadata, close: closeEditMetadata }] =
        useDisclosure(false);

    const [deleteMetadataOpened, { open: openDeleteMetadata, close: closeDeleteMetadata }] =
        useDisclosure(false);

    const handleEditMetadata = (metadata: Metadata) => {
        setCurrentMetadata(metadata);
        openEditMetadata();
    };

    const handleDeleteMetadata = (metadata: Metadata) => {
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
                    <Button leftSection={<IconPlus size={14} />} onClick={openAddMetadata}>
                        Add New Metadata
                    </Button>
                </Flex>
                <DataTable
                    pinLastColumn
                    withTableBorder
                    shadow="xs"
                    borderRadius="sm"
                    withRowBorders={false}
                    highlightOnHover
                    verticalSpacing="md"
                    totalRecords={metadata.total}
                    recordsPerPage={metadata.per_page}
                    page={page}
                    onPageChange={(p) => {
                        setPage(p);
                        handleonPageChange(p);
                    }}
                    columns={[
                        { accessor: "name", noWrap: true },
                        { accessor: "description", noWrap: true },
                        { accessor: "type", noWrap: true },
                        {
                            accessor: "actions",
                            title: <Box mr={6}>Actions</Box>,
                            textAlign: "right",
                            render: (metadata) => (
                                <Group gap={8} justify="right" wrap="nowrap">
                                    <ActionIcon
                                        size="sm"
                                        variant="subtle"
                                        color="gray"
                                        onClick={() => {
                                            handleEditMetadata(metadata);
                                        }}
                                    >
                                        <IconEdit size={48} />
                                    </ActionIcon>
                                    <ActionIcon
                                        size="sm"
                                        variant="subtle"
                                        color="red"
                                        onClick={() => {
                                            handleDeleteMetadata(metadata);
                                        }}
                                    >
                                        <IconTrash size={48} />
                                    </ActionIcon>
                                </Group>
                            ),
                        },
                    ]}
                    records={metadata.data}
                    selectedRecords={selectedRecord}
                    onSelectedRecordsChange={setSelectedRecord}
                />
            </Stack>

            <AddMetadataForm isOpened={addMetadataOpened} close={closeAddMetadata} />

            <EditMetadataForm
                isOpened={editMetadataOpened}
                close={closeEditMetadata}
                metadata={currentMetadata}
            />

            <DeleteMetadataForm
                isOpened={deleteMetadataOpened}
                close={closeDeleteMetadata}
                metadata={currentMetadata}
            />
        </Authenticated>
    );
}