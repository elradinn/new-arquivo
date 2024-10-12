import { Button, Flex, Modal, Select, Stack, Text, TextInput } from "@mantine/core";
import { useUpdateMetadata } from "../Hooks/use-update-metadata";
import { MetadataResourceData } from "../Types/MetadataResourceData";

interface IProps {
    isOpened: boolean;
    close: () => void;
    metadata?: MetadataResourceData;
}

const UpdateMetadataForm: React.FC<IProps> = ({ isOpened, close, metadata }) => {
    const { data, setData, handleEdit, processing, errors } = useUpdateMetadata({ metadata, close });

    return (
        <Modal
            opened={isOpened}
            onClose={close}
            title={<Text size="lg">Edit Metadata</Text>}
            size={550}
        >
            <form onSubmit={handleEdit}>
                <Stack gap={16}>
                    <TextInput
                        id="name"
                        type="text"
                        name="name"
                        value={data.name}
                        label="Name"
                        onChange={(e) => setData("name", e.target.value)}
                        error={errors.name}
                    />

                    <Select
                        label="Type"
                        placeholder="Choose Type"
                        value={data.type}
                        onChange={(_value, option) => setData("type", option.value)}
                        error={errors.type}
                        data={["String", "Boolean", "Datetime"]}
                    />
                </Stack>

                <Flex align="center" justify="end" mt={16}>
                    <Button variant="outline" onClick={close}>
                        Cancel
                    </Button>

                    <Button ml={12} type="submit" loading={processing}>
                        Save
                    </Button>
                </Flex>
            </form>
        </Modal>
    );
};

export default UpdateMetadataForm;
