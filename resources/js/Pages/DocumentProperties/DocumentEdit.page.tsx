import { Head } from "@inertiajs/react";
import {
    ActionIcon,
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
import MetadataInput from "@/Modules/Metadata/Components/MetadataInput";
import RelatedDocumentsInput from "@/Modules/Document/Components/RelatedDocumentsInput";

interface IProps {
    document: DocumentResourceData;
    itemAncestors: ItemAncestorsResourceData[];
}

export default function DocumentEditPage({ document, itemAncestors }: IProps) {
    const handleSave = () => {
        // Implement your save logic here
    };

    const handleClose = () => {
        // Implement your close logic here
    };

    console.log(document);

    return (
        <Authenticated toolbar={<Toolbar page="folder" />}>
            <Head title="Document Properties" />
            <Stack px={8} py={8} gap={24} w={550} mb={72}>
                {/* <Box px={8} py={8} mb={48}>
                    <ItemBreadcrumbs ancestors={itemAncestors} />
                </Box> */}
                <Group mt={24} align="center">
                    <IconFile size={56} stroke={1.5} color="gray" />
                    <Text fw={500}>{document.name}</Text>
                    <ActionIcon variant="subtle" color="gray">
                        <IconEdit size={24} />
                    </ActionIcon>
                </Group>

                <Stack gap={12}>
                    <TextInput
                        label="Document Number"
                        name="document_number"
                        value={document.document_number || ""}
                        onChange={(e) => {
                            // Handle change
                        }}
                        placeholder="Enter document number"
                    />

                    <TextInput type="text" label="Created At" value={document.created_at} disabled />

                    <Textarea
                        label="Description"
                        autosize
                        minRows={4}
                        maxRows={6}
                        placeholder="Enter description"
                        value={document.description || ""}
                        onChange={(e) => {
                            // Handle change
                        }}
                    />

                    <TextInput
                        label="File Path"
                        name="file_path"
                        value={document.file_path || ""}
                        onChange={(e) => {
                            // Handle change
                        }}
                        placeholder="Enter file path"
                    />
                </Stack>

                <Stack gap={12}>
                    <Text size="sm" fw={500}>
                        Custom Metadata Field
                    </Text>

                    <MetadataInput metadata={document.metadata} />

                    <Flex justify="flex-start">
                        <Button variant="subtle" color="blue.5" leftSection={<IconPlus size={18} />}>
                            Add Metadata
                        </Button>
                    </Flex>
                </Stack>

                <Stack gap={12}>
                    <Text size="sm" fw={500}>
                        Related Files
                    </Text>

                    <RelatedDocumentsInput relatedDocuments={document.related_documents} />

                    <Flex justify="flex-start">
                        <Button variant="subtle" color="blue.5" leftSection={<IconPlus size={18} />}>
                            Add Related File
                        </Button>
                    </Flex>
                </Stack>

                <Flex align="center" justify="end" mt={16}>
                    <Button variant="outline" onClick={handleClose}>
                        Cancel
                    </Button>

                    <Button ml={12} type="submit" onClick={handleSave}>
                        Save
                    </Button>
                </Flex>
            </Stack>
        </Authenticated>
    );
}