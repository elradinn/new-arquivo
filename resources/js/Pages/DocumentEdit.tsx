import React, { useState } from "react";
import { Head } from "@inertiajs/react";
import {
    ActionIcon,
    Box,
    Button,
    Flex,
    Group,
    Stack,
    Text,
    Textarea,
    TextInput,
} from "@mantine/core";
import { Authenticated } from "@/Modules/Common/Layouts/AuthenticatedLayout/Authenticated";
import { IconEdit, IconFile, IconPlus } from "@tabler/icons-react";
import Toolbar from "@/Modules/Common/Components/Toolbar/Toolbar";
import { DocumentResourceData } from "@/Modules/Document/Types/DocumentResourceData";
import { ItemAncestorsResourceData } from "@/Modules/Item/Types/ItemAncestorsResourceData";
import ItemBreadcrumbs from "@/Modules/Item/Components/ItemBreadcrumbs";
import MetadataInput from "@/Modules/Document/Components/MetadataInput";
import RelatedDocumentsInput from "@/Modules/Document/Components/RelatedDocumentsInput";
import { useUpdateDocument } from "@/Modules/Document/Hooks/use-update-document";
import { DocumentMetadata } from "@/Modules/Document/Types/DocumentMetadata";

interface IProps {
    document: DocumentResourceData;
    itemAncestors: ItemAncestorsResourceData[];
}

export default function DocumentEditPage({ document, itemAncestors }: IProps) {
    const {
        data,
        setData,
        handleUpdateDocument,
        processing,
        errors,
        reset,
    } = useUpdateDocument({ document });

    const [deletedMetadataIds, setDeletedMetadataIds] = useState<number[]>([]);

    const handleMetadataChange = (updatedMetadata: DocumentMetadata[]) => {
        setData("update_metadata", updatedMetadata);
    };

    const handleMetadataDelete = (metadataId: number) => {
        setDeletedMetadataIds((prev) => [...prev, metadataId]);
        setData("delete_metadata", [...(data.delete_metadata || []), { metadata_id: metadataId }]);
    };

    return (
        <Authenticated toolbar={<Toolbar page="folder" />}>
            <Head title="Document Properties" />
            <Stack px={8} py={8} gap={24} w={550} mb={72}>
                {/* <Box px={8} py={8} mb={48}>
                    <ItemBreadcrumbs ancestors={itemAncestors} />
                </Box> */}
                <Group mt={24} align="center">
                    <IconFile size={56} stroke={1.5} color="gray" />
                    <Text fw={500}>{data.name}</Text>
                    <ActionIcon variant="subtle" color="gray">
                        <IconEdit size={24} />
                    </ActionIcon>
                </Group>

                <form onSubmit={handleUpdateDocument}>
                    <Stack gap={12}>
                        <TextInput
                            label="Document Number"
                            name="document_number"
                            value={data.document_number}
                            onChange={(e) => setData("document_number", e.target.value)}
                            placeholder="Enter document number"
                        />

                        <TextInput type="text" label="Created At" value={document.created_at} disabled />

                        <Textarea
                            label="Description"
                            autosize
                            minRows={4}
                            maxRows={6}
                            placeholder="Enter description"
                            value={data.description}
                            onChange={(e) => setData("description", e.target.value)}
                        />
                    </Stack>

                    <Stack gap={12}>
                        <Text size="sm" fw={500}>
                            Custom Metadata Field
                        </Text>

                        <MetadataInput
                            metadata={data.update_metadata ?? []}
                            requiredMetadata={document.required_folder_metadata}
                            onChange={handleMetadataChange}
                            onDelete={handleMetadataDelete}
                        />

                    </Stack>

                    {/* <Stack gap={12}>
                        <Text size="sm" fw={500}>
                            Related Files
                        </Text>

                        <RelatedDocumentsInput
                            relatedDocuments={data.related_documents}
                            onChange={(updatedRelatedDocs) => setData("related_documents", updatedRelatedDocs)}
                        />

                        <Flex justify="flex-start">
                            <Button variant="subtle" color="blue.5" leftSection={<IconPlus size={18} />}>
                                Add Related File
                            </Button>
                        </Flex>
                    </Stack> */}

                    <Flex align="center" justify="end" mt={16}>
                        <Button variant="outline" type="button" onClick={() => window.history.back()}>
                            Cancel
                        </Button>

                        <Button ml={12} type="submit" loading={processing}>
                            Save
                        </Button>
                    </Flex>
                </form>
            </Stack>
        </Authenticated>
    );
}
